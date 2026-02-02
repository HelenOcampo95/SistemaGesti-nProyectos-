<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Events\ProyectoCreado;
use App\Http\Requests\Proyectos\RegistrarProyectoRequest;
use App\Models\Categorias;
use App\Models\Proyecto;
use App\Models\Role;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProyectoController extends Controller
{
    //Vista de proyecto
    public function verProyecto(){
        $userId = auth()->id();

        $proyectos = Proyecto::whereHas('participantes', function($query) use ($userId) {
            // Especificamos la tabla para evitar la ambigüedad
            $query->where('participantes_proyecto.id_usuario', $userId);
        })
        ->orWhere('id_usuario', $userId)
        ->orWhere('id_docente_director', $userId) // Asegúrate de que estos nombres coincidan con tu DB
        ->orWhere('id_docente_lider', $userId)
        ->paginate(9);

        return view('proyecto.proyecto')->with(['proyectos' => $proyectos]);
    }

    //Registrar el proyecto.
    public function registrarProyecto(Request $request)
    {
        // 1. Validar la información
        $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'id_categoria'    => 'required',
            'colaboradores'   => 'nullable|array' 
        ]);

        $regla = DB::table('categoria_docente_responsable')
        ->where('id_categoria', $request->id_categoria)
        ->first();

        DB::beginTransaction();

        try {
            // 2. Crear el Proyecto
            $proyecto = new Proyecto();
            $proyecto->nombre_proyecto      = $request->nombre_proyecto;
            $proyecto->descripcion_proyecto = $request->descripcion_proyecto;
            $proyecto->fecha_inicio         = $request->fecha_inicio;
            $proyecto->fecha_entrega        = $request->fecha_entrega;
            $proyecto->estado_proyecto      = $request->estado_proyecto;
            $proyecto->id_categoria         = $request->id_categoria;
            $proyecto->id_usuario           = Auth::id();
            $proyecto->id_docente_director  = $regla->id_docente_director;
            $proyecto->id_docente_lider     = $regla->id_docente_lider;
            $proyecto->save();

            // 3. Procesar Colaboradores
            if (!empty($request->colaboradores)) {
                foreach ($request->colaboradores as $correo) {
                    
                    // A. Buscar o crear el usuario invitado
                    $usuario = Usuarios::firstOrCreate(
                        ['correo_usuario' => $correo],
                        [
                            'nombre_usuario'   => 'Invitado',
                            'apellido_usuario' => 'Pendiente',
                            'id_rol'           => 2, 
                            'cedula_usuario'   => '000' . rand(1000, 9999),
                            'password'         => bcrypt('123456')
                        ]
                    );

                    // B. Insertar en tabla pivote (SOLO IDs)
                    DB::table('sgp.participantes_proyecto')->insert([
                        'id_usuario'  => $usuario->id_usuario,
                        'id_proyecto' => $proyecto->id_proyecto,
                        'creado_en'  => now(),
                        'actualizado_en'  => now()
                        
                    ]);
                }
            }

            DB::commit();
            
            $DashboardController = new DashboardController();
            $data = $DashboardController->obtenerDashboardData($regla->id_docente_lider);
    
            event(new DashboardUpdated($data));

            return response()->json(['mensaje' => 'Proyecto creado con éxito', 'id' => $proyecto->id_proyecto], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error: " . $e->getMessage());
            return response()->json(['error' => 'Error al registrar', 'detalle' => $e->getMessage()], 422);
        }
    }

    //Select:Listar todos los usuarios.
    public function traerUsuario(Request $request){
        $usuario = Usuarios::select('id_usuario', 'nombre_usuario')
            ->where(function($query) use ($request){
                $query->where('nombre_usuario', 'like', '%'. $request->busqueda. '%');
            })
            ->limit(50)
            ->get();
            return response()->json($usuario, 200);
    }

    //Select:Listar todas las categorias.
    public function traerCategoria(Request $request){
    $categoria = Categorias::select('id_categoria', 'nombre_categoria')
            ->where(function ($query) {
                $query->whereNull('eliminado_en')
                    ->orWhere('eliminado_en', '0000-00-00 00:00:00');
            })
            ->where('nombre_categoria', 'like', '%'. $request->busqueda. '%')
            ->limit(50)
            ->get();

    return response()->json($categoria, 200);

    }
    public function detalleProyecto($id_proyecto)
    {
        // 1. Traemos el proyecto con sus datos básicos
        $proyecto = Proyecto::with(['categoria', 'usuario'])->findOrFail($id_proyecto);

        // 2. Traemos las tareas filtradas por estado, limitando a 5 por cada grupo
        // Usamos el método latest() para que aparezcan las más recientes primero
        $pendientes = $proyecto->tareas()
            ->where('estado_tarea', 'pendiente')
            ->oldest('fecha_entrega')
            ->take(5)
            ->get();

        $enDesarrollo = $proyecto->tareas()
            ->where('estado_tarea', 'en proceso') // Asegúrate de que el nombre del estado coincida con tu BD
            ->oldest('fecha_entrega')
            ->take(5)
            ->get();

        $finalizadas = $proyecto->tareas()
            ->where('estado_tarea', 'finalizada')
            ->oldest('fecha_entrega')
            ->take(5)
            ->get();

        // 3. Pasamos todas las variables a la vista
        return view('proyecto.detalle_proyecto', compact(
            'proyecto', 
            'pendientes', 
            'enDesarrollo', 
            'finalizadas',
        ));
    }

    //Actualizar información del proyecto.
    public function actualizarProyecto(Request $request)
    {
        try {
            $proyecto                       = Proyecto::where('id_proyecto', $request->id_proyecto)->firstOrFail();
            $proyecto->nombre_proyecto      = $request->nombre_proyecto; 
            $proyecto->descripcion_proyecto = $request->descripcion_proyecto;
            $proyecto->save();

            return response()->json('Proyecto actualizado correctamente', 200);

        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Error al procesar la información',
                'detalle' => $e->getMessage(),
                'linea'   => $e->getLine(),
                'archivo' => $e->getFile(),
            ], 500);
        }
    }

    public function selectProyecto(Request $request){
        $proyecto = Proyecto::select('id_proyecto', 'nombre_proyecto')
            ->where(function($query) use ($request){
                $query->where('nombre_proyecto', 'like', '%'. $request->busqueda. '%');
            })
            ->limit(50)
            ->get();
            return response()->json($proyecto, 200);
    }

    public function verListadoProyecto(){
        return view('proyecto.ver_proyectos');
    }
    //Listar proyectos para los roles de Docente director y docente lider.
    public function listarProyecto(Request $request){

        $proyectos = Proyecto::with(['categoria']);
        
        return DataTables::eloquent($proyectos)
            ->addColumn('nombre_proyecto', fn($c) => $c->nombre_proyecto ?? 'Sin proyecto')
            ->addColumn('estado_proyecto', fn($c) => $c->estado_proyecto ?? 'Sin estado')
            ->addColumn('fecha_inicio', fn($c) => $c->fecha_inicio?? 'Sin fechas')
            ->addColumn('nombre_categoria', fn($c) => $c->categoria->nombre_categoria?? 'Sin categoria')
            ->filter(function ($query) use ($request) {
                $buscar = $request->input('buscar');
                if (!empty($buscar)) {
                    $query->whereHas('categoria', function($q) use ($buscar) {
                        $q->where('nombre_categoria', 'like', "%{$buscar}%");
                    })
                    ->orWhere('nombre_proyecto', 'like', "%{$buscar}%")
                    ->orWhere('estado_proyecto', 'like', "%{$buscar}%");
                }
            })
            ->toJson();
    }
    

}
