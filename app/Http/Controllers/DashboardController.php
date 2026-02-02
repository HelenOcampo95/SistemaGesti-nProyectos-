<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Tareas;
use App\Models\Usuarios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use SebastianBergmann\Environment\Console;

class DashboardController extends Controller
{
    public function verDashboard()
    {
        $fechaActual = Carbon::now()->toDateString();
        $id_docente = auth()->user()->id_usuario; 
        

        $totalProyectos = Proyecto::where('id_docente_lider', $id_docente)->count();

        //Consultas KPIs proyecto
        $proyectosActivos = Proyecto::where('id_docente_lider', $id_docente)
                            ->where('estado_proyecto', 'Activo')->count();
        $proyectosFinalizados = Proyecto::where('id_docente_lider', $id_docente)
                            ->where('estado_proyecto', 'Finalizada')->count();

        $proyectosAtrasados = Proyecto::where('id_docente_lider', $id_docente)
                            ->where('fecha_entrega', '>', $fechaActual)->count();
        $proyectosAvalados = Proyecto::where('estado_proyecto', 'Avalado')->count();

        //Contador para las tareas
        $queryTareas = function() use ($id_docente) {
            return Tareas::whereHas('proyecto', function($q) use ($id_docente) {
                $q->where('id_docente_lider', $id_docente);
            });
        };

        $totalPendientes = (clone $queryTareas())->where('estado_tarea', 'Pendiente')->count();
        $totalEnProceso  = (clone $queryTareas())->where('estado_tarea', 'En Proceso')->count();
        $totalFinalizado = (clone $queryTareas())->where('estado_tarea', 'Finalizada')->count();

        //Consulta de estudiantes Activos
        $proyectos = Proyecto::with('categoria')->get();
        
        $conteoPorFacultad = $proyectos->countBy(function ($proyecto) {
            return $proyecto->facultad->nombre_facultad ?? 'Sin Asignar';
        });

        $total = $proyectos->count();

        $participacion = $conteoPorFacultad->map(function ($cantidad, $nombre) use ($total) {
            return [
                'facultad' => $nombre,
                'cantidad' => $cantidad,
                'porcentaje' => $total > 0 ? round(($cantidad * 100) / $total, 2) : 0
            ];
        })->values();

        $estudiantes = Usuarios::role('estudiante')->count();

        return view('dashboard.dashboard', compact(
            'totalProyectos',
            'proyectosActivos',
            'proyectosFinalizados',
            'proyectosAtrasados',
            'proyectosAvalados',
            'totalPendientes',
            'totalEnProceso',
            'totalFinalizado',
            'participacion',
            'estudiantes'
        ));
    }

    public function obtenerDashboardData($id_docente = null) 
    {

        $id_docente = $id_docente ?? auth()->user()->id_usuario;
        $fechaActual = \Carbon\Carbon::now()->toDateString();

        $queryTareas = function() use ($id_docente) {
            return Tareas::whereHas('proyecto', function($q) use ($id_docente) {
                $q->where('id_docente_lider', $id_docente);
            });
        };

        $total = Proyecto::count();
        $proyectos = Proyecto::with('categoria')->get();
        
        $conteoPorFacultad = $proyectos->countBy(function ($proyecto) {
            return $proyecto->categoria->nombre_categoria ?? 'Sin Asignar';
        });

        $participacion = $conteoPorFacultad->map(function ($cantidad, $nombre) use ($total) {
            return [
                'facultad' => str_replace('Facultad de ', 'Fac. ', $nombre),
                'cantidad' => $cantidad,
                'porcentaje' => $total > 0 ? round(($cantidad / $total) * 100, 2) : 0
            ];
        })->values();

        // Retorna un ARRAY directo, no un response()->json()
        return [
            'totalProyectos'       => Proyecto::where('id_docente_lider', $id_docente)->count(),
            'proyectosActivos'     => Proyecto::where('id_docente_lider', $id_docente)->where('estado_proyecto', 'Activo')->count(),
            'proyectosFinalizados' => Proyecto::where('id_docente_lider', $id_docente)->where('estado_proyecto', 'Finalizada')->count(),
            'proyectosAtrasados'   => Proyecto::where('id_docente_lider', $id_docente)->where('fecha_entrega', '>', $fechaActual)->count(),
            'proyectosAvalados'    => Proyecto::where('estado_proyecto', 'Avalado')->count(),
            'totalPendientes'      => (clone $queryTareas())->where('estado_tarea', 'Pendiente')->count(),
            'totalEnProceso'       => (clone $queryTareas())->where('estado_tarea', 'En Proceso')->count(),
            'totalFinalizado'      => (clone $queryTareas())->where('estado_tarea', 'Finalizada')->count(),
            'participacion'        => $participacion,
            'estudiantes'          => $estudiantes = Usuarios::role('estudiante')->count()
        ];
    }


}
