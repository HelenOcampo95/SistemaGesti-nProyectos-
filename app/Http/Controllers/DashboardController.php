<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Proyecto;
use App\Models\Tareas;
use App\Models\Usuarios;
use App\Models\Versiones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use SebastianBergmann\Environment\Console;

class DashboardController extends Controller
{

    public function verDashboard(Request $request)
    {
        $user = auth()->user();
        $esAdmin = $user->hasRole('Administrador');
        $id_docente = $esAdmin ? null : $user->id_usuario;
        $fechaActual = Carbon::now()->toDateString();

        // --- CONSULTAS DE PROYECTOS ---
        // Si hay id_docente filtra, si no, trae todo (whereNotNull se usa como truco para ignorar el filtro)
        $queryBaseProyectos = Proyecto::when($id_docente, function ($q) use ($id_docente) {
            // Agrupamos los OR dentro de un WHERE padre
            return $q->where(function($subQuery) use ($id_docente) {
                $subQuery->where('id_docente_lider', $id_docente)
                        ->orWhere('id_docente_director', $id_docente)
                        ->orWhere('id_usuario', $id_docente)
                        ->orWhereHas('participantes', function($p) use ($id_docente) {
                            $p->where('usuarios.id_usuario', $id_docente); 
                        });
            });
        });

        $totalProyectos = (clone $queryBaseProyectos)->count();
        $proyectosActivos = (clone $queryBaseProyectos)->where('estado_proyecto', 'Activo')->count();
        $proyectosFinalizados = (clone $queryBaseProyectos)->where('estado_proyecto', 'Finalizado')->count();
        $proyectosAtrasados = (clone $queryBaseProyectos)->where('fecha_entrega', '<', $fechaActual)->count();
        $proyectosAvalados = Proyecto::where('estado_proyecto', 'Avalado')->count(); // Este suele ser global

        // --- CONSULTAS DE TAREAS ---
        $queryTareas = Tareas::whereHas('proyecto', function ($q) use ($id_docente) {
            // Si id_filtro tiene valor (Docente o Estudiante), aplicamos la restricción
            $q->when($id_docente, function ($query) use ($id_docente) {
                return $query->where(function($sub) use ($id_docente) {
                    $sub->where('id_docente_lider', $id_docente)
                        ->orWhere('id_docente_director', $id_docente)
                        ->orWhere('id_usuario', $id_docente)
                        // Buscamos si el usuario está en la tabla de participantes
                        ->orWhereHas('participantes', function($p) use ($id_docente) {
                            $p->where('usuarios.id_usuario', $id_docente); 
                        });
                });
            });
        });

        $totalTareas = (clone $queryTareas)->count();
        $totalAsignadas = (clone $queryTareas)->where('estado_tarea', 'Asignada')->count();
        $totalEntregadas = (clone $queryTareas)->where('estado_tarea', 'Entregadas')->count();
        $totalFinalizadas = (clone $queryTareas)->where('estado_tarea', 'Finalizada')->count();
        $totalCorregidas = (clone $queryTareas)->where('estado_tarea', 'Corregir')->count();

        // El listado de tareas con la relación cargada para evitar lentitud (N+1)
        $tareas = (clone $queryTareas)->where('estado_tarea', Tareas::ENTREGADAS)->with('proyecto')->get();

        // --- LISTADO DE VERSIONES PENDIENTES ---
        $versiones = Versiones::whereHas('proyecto', function($q) use ($id_docente) {
                if ($id_docente) { 
                    $q->where('id_docente_lider', $id_docente)
                        ->orWhere('id_docente_director', $id_docente)
                        ->orWhere('id_usuario', $id_docente)
                        ->orWhereHas('participantes', function($p) use ($id_docente) {
                            $p->where('usuarios.id_usuario', $id_docente); 
                        });
                }
            })
            ->where('estado_version', Versiones::PENDIENTE) 
            ->latest('fecha_modificacion') 
            ->get();

        // --- TABLA DE PROYECTOS (Buscador) ---
        $buscar = $request->get('buscarProyecto');
        $porcentajeProyecto = Proyecto::when($id_docente, function ($q) use ($id_docente) {
                return $q->where('id_docente_lider', $id_docente)
                ->orWhere('id_docente_director', $id_docente)
                ->orWhere('id_usuario', $id_docente)
                ->orWhereHas('participantes', function($p) use ($id_docente) {
                            $p->where('usuarios.id_usuario', $id_docente); 
                        });
            })
            ->when($buscar, function ($query, $buscar) {
                return $query->where('nombre_proyecto', 'LIKE', "%{$buscar}%");
            })
            ->withSum('tareas as avance_total', 'porcentaje_avance')
            ->get()
            ->map(function ($proyecto) {
                $proyecto->progreso_real = (float)($proyecto->avance_total ?? 0);
                $proyecto->color_progreso = $proyecto->progreso_real <= 30 ? 'danger' : ($proyecto->progreso_real <= 70 ? 'warning' : 'success');
                return $proyecto;
            });

        // Otros datos globales
        $estudiantes = Usuarios::role('Estudiante')->count();
        $totalProyectosGeneral = Proyecto::count();
        $participacion = $this->obtenerDashboardData($totalProyectosGeneral);

        return view('dashboard.dashboard', compact(
            'totalProyectos', 'proyectosActivos', 'proyectosFinalizados', 'proyectosAtrasados',
            'proyectosAvalados', 'totalTareas', 'totalAsignadas', 'totalEntregadas', 'totalCorregidas',
            'totalFinalizadas', 'participacion', 'totalProyectosGeneral', 'estudiantes',
            'versiones', 'porcentajeProyecto', 'tareas'
        ));
    }

    public function obtenerDashboardData($id_docente = null) 
    {

        $user = auth()->user();
        $fechaActual = Carbon::now()->toDateString();
        
        // Si es administrador, dejamos el ID en null para no filtrar
        $esAdmin = $user->hasRole('Administrador'); 
        $id_docente = $esAdmin ? null : $user->id_usuario;


        $totalProyectos = Proyecto::count();

        $participacion = Categorias::withCount('proyectos')
            ->get()
            ->map(function ($categoria) use ($totalProyectos) {

                $cantidad = $categoria->proyectos_count;
                $nombre   = strtolower($categoria->nombre_categoria);

                // 1️⃣ Abreviar "Facultad de"
                $facultad = str_replace('Facultad de ', 'Fac. ', $categoria->nombre_categoria);

                // 2️⃣ Abreviar "ciencias" donde aparezca
                $facultad = str_ireplace('ciencias', 'Cien.', $facultad);

                // 3️⃣ Abreviar administración si aplica
                $facultad = str_ireplace('administrativas', 'Adm.', $facultad);

                return [
                    'facultad'   => $facultad,
                    'cantidad'   => $cantidad,
                    'porcentaje' => $totalProyectos > 0
                        ? round(($cantidad * 100) / $totalProyectos, 2)
                        : 0
                ];
            })
            ->values();

        $estudiantes = Usuarios::role('Estudiante')->count();

        $queryBaseProyectos = Proyecto::when($id_docente, function ($q) use ($id_docente) {
            // Agrupamos los OR dentro de un WHERE padre
            return $q->where(function($subQuery) use ($id_docente) {
                $subQuery->where('id_docente_lider', $id_docente)
                        ->orWhere('id_docente_director', $id_docente)
                        ->orWhere('id_usuario', $id_docente)
                        ->orWhereHas('participantes', function($p) use ($id_docente) {
                            $p->where('usuarios.id_usuario', $id_docente); 
                        });
            });
        });

        $totalProyectos = (clone $queryBaseProyectos)->count();
        $proyectosActivos = (clone $queryBaseProyectos)->where('estado_proyecto', 'Activo')->count();
        $proyectosFinalizados = (clone $queryBaseProyectos)->where('estado_proyecto', 'Finalizado')->count();
        $proyectosAtrasados = (clone $queryBaseProyectos)->where('fecha_entrega', '<', $fechaActual)->count();
        $proyectosAvalados = Proyecto::where('estado_proyecto', 'Avalado')->count(); // Este suele ser global

         //Contador para las tareas
        $queryTareas = Tareas::whereHas('proyecto', function ($q) use ($id_docente) {
            // Si id_filtro tiene valor (Docente o Estudiante), aplicamos la restricción
            $q->when($id_docente, function ($query) use ($id_docente) {
                return $query->where(function($sub) use ($id_docente) {
                    $sub->where('id_docente_lider', $id_docente)
                        ->orWhere('id_docente_director', $id_docente)
                        ->orWhere('id_usuario', $id_docente)
                        // Buscamos si el usuario está en la tabla de participantes
                        ->orWhereHas('participantes', function($p) use ($id_docente) {
                            $p->where('usuarios.id_usuario', $id_docente); 
                        });
                });
            });
        });

        $totalTareas = (clone $queryTareas)->count();
        $totalAsignada = (clone $queryTareas)->where('estado_tarea', 'Asignada')->count();
        $totalEntregadas = (clone $queryTareas)->where('estado_tarea', 'Entregadas')->count();
        $totalFinalizado = (clone $queryTareas)->where('estado_tarea', 'Finalizada')->count();
        $totalCorregidas = (clone $queryTareas)->where('estado_tarea', 'Corregir')->count();
        // El listado de tareas con la relación cargada para evitar lentitud (N+1)
        $tareas = (clone $queryTareas)->with('proyecto')->where('estado_tarea', Tareas::ENTREGADAS)->get();

        $versiones = Versiones::whereHas('proyecto')
        ->whereHas('proyecto', function($q) use ($id_docente) {
            $q->where('id_docente_lider', $id_docente)
            ->orWhere('id_usuario', $id_docente)
            ->orWhereHas('participantes', function($p) use ($id_docente) {
                $p->where('usuarios.id_usuario', $id_docente); 
            });
        })
        ->where('estado_version', VERSIONES::PENDIENTE) // Solo lo que falta por aceptar
        ->latest('fecha_modificacion') // La más reciente primero
        ->get();

        //Listar los proyectos con su versión y porcentaje de avance
        $porcentajeProyecto = Proyecto::where('id_docente_lider', $id_docente)
            ->with(['versiones' => function($query) {
                $query->latest('creado_en')->limit(1); 
            }])
            // Sumamos la columna 'porcentaje_avance' de la tabla 'tareas'
            ->withSum('tareas as avance_total', 'porcentaje_avance')
            ->get()
            ->map(function ($proyecto) {
                // Formateamos la respuesta
                $proyecto->ultima_version = $proyecto->versiones->first();
                
                // Aseguramos que el avance no supere el 100% y sea un número limpio
                $proyecto->progreso_real = $proyecto->avance_total ? (float)$proyecto->avance_total : 0;

                // Limpiamos el historial de versiones para el JSON
                unset($proyecto->versiones);
                
                return $proyecto;
        });



        // Retorna un ARRAY directo, no un response()->json()
        return [
            'totalProyectos'       => $totalProyectos,
            'proyectosActivos'     => $proyectosActivos,
            'proyectosFinalizados' => $proyectosFinalizados,
            'proyectosAtrasados'   => $proyectosAtrasados,
            'proyectosAvalados'    => $proyectosAvalados,
            'totalTareas'          => $totalTareas ?? 0,
            'totalAsignadas'       => $totalAsignada,
            'totalEntregadas'      => $totalEntregadas,
            'totalFinalizadas'     => $totalFinalizado,
            'totalCorregidas'      => $totalCorregidas,
            'participacion'        => $participacion,
            'totalProyectosGeneral'=> $totalProyectos,
            'estudiantes'          => $estudiantes,
            'tareas'               => $tareas,
            'listarProyectos'      => Proyecto::where('id_docente_lider', $id_docente),
            'versiones'            => $versiones,
            'porcentajeProyecto'   => $porcentajeProyecto
        ];
    }


}
