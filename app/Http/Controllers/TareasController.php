<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Events\NotificacionUsuario;
use App\Events\TareaCreada;
use App\Http\Requests\Tareas\RegistrarTareasRequest;
use App\Models\Tareas;
use App\Models\Versiones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\EventDispatcher\Event;
use Yajra\DataTables\Facades\DataTables;

class TareasController extends Controller
{
    public function verTareas(){
        return view('tareas.asignar_tareas');
    }

    public function asignarTarea(RegistrarTareasRequest $request): JsonResponse
    {
    
        try{
            $tarea                          = new Tareas();
            $tarea->descripcion_tarea       = $request->descripcion_tarea;
            $tarea->fecha_entrega           = $request->fecha_entrega;
            $tarea->estado_tarea            = Tareas::ASIGNADA;
            $tarea->observaciones_docente   = $request->observaciones_docente;
            $tarea->porcentaje_avance       = $request->porcentaje_avance;
            $tarea->id_proyecto             = $request->id_proyecto;
            $tarea->titulo_tarea            = $request->titulo_tarea;
            $tarea->save(); 
            
        $idDueño = $tarea->proyecto->id_usuario; // El que registró el proyecto
        
        // Extraemos los IDs de la tabla de participantes
        $idsParticipantes = $tarea->proyecto->participantes->pluck('id_usuario')->toArray();

        // Combinamos ambos (Dueño + Participantes)
        $destinatarios = array_merge([$idDueño], $idsParticipantes);

        foreach ($destinatarios as $idUsuario) {

            $notificacion = \App\Models\Notificacion::create([
                'id_usuario'                => $idUsuario,
                'tipo_notificacion'         => 'tarea',
                'id_referencia'             => $tarea->id_tarea,
                'titulo_notificacion'       => 'Tarea asignada',
                'descripcion_notificacion'  => "El docente ha asignado una tarea:". ($tarea->titulo_tarea ?? 'Sin nombre'),
                'url_notificacion'          => "/tarea/{$tarea->id_tarea}", 
                'leida'                     => 0
            ]); 

            // Obtenemos la data específica para cada usuario del equipo
            event(new NotificacionUsuario(($notificacion)));
        }    
            return response()->json('La tarea se ha asignado correctamente', 200);   
        }catch (\Exception $e) {
            return response()->json('Error al asignar la tarea' . $e->getMessage(), 422);
        }
        
    }

    public function listarTareas(Request $request)
    {
        $tareas = Tareas::with('proyecto')->whereHas('proyecto', function($query) {
            $query->where('id_docente_lider', auth()->id())
            ->orWhere('id_docente_director',auth()->id()); 
        });

        return DataTables::eloquent($tareas)
            ->addColumn('nombre_proyecto', fn($c) => $c->proyecto->nombre_proyecto ?? 'Sin proyecto')
            ->addColumn('titulo_tarea', fn($c) => $c->titulo_tarea ?? 'Sin título')
            ->addColumn('descripcion_tarea', fn($c) => $c->descripcion_tarea ?? 'Sin descripción')
            ->addColumn('fecha_entrega', fn($c) => $c->fecha_entrega ?? 'Sin fechas')
            ->addColumn('estado_tarea', fn($c) => $c->estado_tarea ?? 'Sin estado')
            ->addColumn('observaciones_docente', fn($c) => $c->observaciones_docente ?? 'Sin observaciones')
            ->filter(function ($query) use ($request) {
                $buscar = $request->input('buscar');
                if (!empty($buscar)) {
                    $query->whereHas('proyecto', function($q) use ($buscar) {
                        $q->where('nombre_proyecto', 'like', "%{$buscar}%");
                    })
                    ->orWhere('descripcion_tarea', 'like', "%{$buscar}%")
                    ->orWhere('estado_tarea', 'like', "%{$buscar}%");
                }
            })
            ->toJson();
    }

    public function actualizarTarea(Request $request, $id_tareas)
    {
        try{
            $tarea  = Tareas::findOrFail($id_tareas);
            
            if (!$request->filled('titulo_tarea') && 
            !$request->filled('descripcion_tarea') && 
            !$request->filled('observaciones_docente')) {
            
            return response()->json([
                'error' => 'Debes enviar al menos un campo (título, descripción u observaciones) para actualizar.'
            ], 422);
        }

            if ($request->filled('titulo_tarea')) {
                $tarea->titulo_tarea = $request->titulo_tarea;
            }

            if ($request->filled('descripcion_tarea')) {
                $tarea->descripcion_tarea = $request->descripcion_tarea;
            }

            if ($request->filled('observaciones_docente')) {
                $tarea->observaciones_docente = $request->observaciones_docente;
            }

            $tarea->save();

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Tarea actualizada correctamente',
                'datos_actualizados' => $tarea->only(['titulo_tarea', 'descripcion_tarea', 'observaciones_docente'])
            ], 200);

        } catch (\Exception $e){
            return response()->json([
                'error' => 'Error al procesar la información',
                'detalle' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile(),
            ], 500);
        }
    }

    public function eliminarTarea($id_tarea){
        try {
            $tarea = Tareas::findOrFail($id_tarea);
            $tarea->eliminado_en = Carbon::now();
            $tarea->save();

            return response()->json([
                'message' => 'Tarea eliminada correctamente'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Tarea no encontrada'
            ], 404);
        } catch (\Illuminate\Database\QueryException $e) {
            // Esto captura errores por llaves foráneas
            return response()->json([
                'error' => 'No se puede eliminar esta tarea porque tiene registros asociados'
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function detalleTarea($id_tarea){

        $tarea      = Tareas::with('proyecto.versiones')->findOrFail($id_tarea);
        $estados    = Tareas::getEstados();
        return view('tareas.detalle_tarea')->with([
            'tarea' => $tarea,
            'estados' => $estados
        ]);
    }

    public function entregarTarea(Request $request, $id_tarea){

    try{
        $tarea = Tareas::with('proyecto')->findOrFail($id_tarea);

        if ($tarea->intentos_realizados >= 2) {
            return redirect()->back()->with('error', 'No puedes subir más intentos para esta tarea.');
        }

        $tarea->id_tarea            = $id_tarea;
        $tarea->estado_tarea        = TAREAS::ENTREGADAS;
        $tarea->url_tarea           = $request->url_tarea;
        $tarea->intentos_realizados += 1;
        $tarea->save();

        if ($request->es_version) {
            $version = Versiones::where('id_proyecto', $tarea->id_proyecto)
                                ->where('archivos_relacionados', $tarea->url_tarea) 
                                // O mejor aún, si tienes una columna id_tarea en versiones, úsala.
                                ->first();

            if (!$version) {
                $version = new Versiones();
                $version->id_proyecto = $tarea->id_proyecto;
            }

            $version->version               = $request->tag;
            $version->descripcion_cambios   = $request->descripcion_cambios;
            $version->fecha_modificacion    = now();
            $version->archivos_relacionados = $request->url_tarea;
            $version->estado_version        = VERSIONES::PENDIENTE; 
            $version->save();
        }

        $idDocente = $tarea->proyecto->id_docente_lider;

        $notificacion = \App\Models\Notificacion::create([
            'id_usuario'                => $idDocente,
            'tipo_notificacion'         => 'tarea',
            'id_referencia'             => $tarea->id_tarea,
            'titulo_notificacion'       => 'Nueva Entrega de Tarea',
            'descripcion_notificacion'  => "El equipo ha entregado la tarea:". ($tarea->titulo_tarea ?? 'Sin nombre'),
            'url_notificacion'          => "/tarea/{$tarea->id_tarea}", 
            'leida'                     => 0
        ]);

        $DashboardController = new DashboardController();
        $data = $DashboardController->obtenerDashboardData($idDocente);
        $dataLimpia = json_decode(json_encode($data), true); 

        event(new DashboardUpdated($dataLimpia));
        event( new NotificacionUsuario($notificacion));

        return response()->json(['mensaje' => 'Tarea entregada correctamente']);

    } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function calificarTarea(Request $request, $id_tarea){
        try{
            $tarea  = Tareas::with(['proyecto.participantes'])->findOrFail($id_tarea);
            
            if (!$request->filled('estado_tarea') && 
            !$request->filled('porcentaje_avance') && 
            !$request->filled('observaciones_docente')) {
            
            return response()->json([
                'error' => 'Debes enviar al menos un campo para actualizar.'
            ], 422);
        }

            if ($request->filled('estado_tarea')) {
                $tarea->estado_tarea = $request->estado_tarea;
            }
            if ($request->filled('porcentaje_avance')) {
                $tarea->porcentaje_avance = $request->porcentaje_avance;
            }
            if ($request->filled('observaciones_docente')) {
                $tarea->observaciones_docente = $request->observaciones_docente;
            }
            $tarea->save();

        $idDueño = $tarea->proyecto->id_usuario; // El que registró el proyecto
        
        // Extraemos los IDs de la tabla de participantes
        $idsParticipantes = $tarea->proyecto->participantes->pluck('id_usuario')->toArray();

        // Combinamos ambos (Dueño + Participantes)
        $destinatarios = array_merge([$idDueño], $idsParticipantes);

        // 4. Instanciar Dashboard e iterar
        $DashboardController = new DashboardController();

        foreach ($destinatarios as $idUsuario) {

            $notificacion = \App\Models\Notificacion::create([
                'id_usuario'                => $idUsuario,
                'tipo_notificacion'         => 'tarea',
                'id_referencia'             => $tarea->id_tarea,
                'titulo_notificacion'       => 'Tarea calificada',
                'descripcion_notificacion'  => "El docente ha calificado la tarea:". ($tarea->titulo_tarea ?? 'Sin nombre'),
                'url_notificacion'          => "/tarea/{$tarea->id_tarea}", 
                'leida'                     => 0
            ]); 

            // Obtenemos la data específica para cada usuario del equipo
            $data = $DashboardController->obtenerDashboardData($idUsuario);
            // Convertimos a array limpio
            $dataLimpia = json_decode(json_encode($data), true); 

            // Disparamos el evento individual
            // Es vital que DashboardUpdated reciba el ID para canalizarlo correctamente
            event(new DashboardUpdated($idUsuario, $dataLimpia));
            event(new NotificacionUsuario(($notificacion)));
        }

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Tarea actualizada correctamente'
            ], 200);

        } catch (\Exception $e){
            return response()->json([
                'error' => 'Error interno en el servidor',
                'detalle' => $e->getMessage()
            ], 500);
        }

    }
}
