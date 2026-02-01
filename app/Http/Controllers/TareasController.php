<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Events\ProyectoCreado;
use App\Events\TareaActualizada;
use App\Events\TareaCreada;
use App\Models\Tareas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Contracts\EventDispatcher\Event;
use Yajra\DataTables\Facades\DataTables;

class TareasController extends Controller
{
    public function verTareas(){
        return view('tareas.asignar_tareas');
    }

    public function asignarTarea(Request $request){
    
        try{
            $tarea                          = new Tareas();
            $tarea->descripcion_tarea       = $request->descripcion_tarea;
            $tarea->fecha_entrega           = $request->fecha_entrega;
            $tarea->estado_tarea            = $request->estado_tarea;
            $tarea->observaciones_docente   = $request->observaciones_docente;
            $tarea->porcentaje_avance       = $request->porcentaje_avance;
            $tarea->id_proyecto             = $request->id_proyecto;
            $tarea->titulo_tarea            = $request->titulo_tarea;
            $tarea->save();   
            
            return response()->json('La tarea se ha asignado correctamente', 200);   
        }catch (\Exception $e) {
            return response()->json('Error al asignar la tarea' . $e->getMessage(), 422);
        }
        
    }

    public function listarTareas(Request $request)
    {
        $tareas = Tareas::with('proyecto')->whereHas('proyecto', function($query) {
            $query->where('id_docente_lider', auth()->id()); 
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
            if (!$request->hasAny(['titulo_tarea','descripcion_tarea', 'observaciones_docente'])) {
                return response()->json([
                    'error' => 'Debe enviar al menos una descripción o una observación'
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

            return response()->json('Tarea actualizada correctamente');

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
            $tarea->delete();

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
                'error' => 'No se puede eliminar esta categoría porque tiene registros asociados'
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function detalleTarea($id_tarea){

        $tarea = Tareas::with('proyecto')->findOrFail($id_tarea);

        return view('tareas.detalle_tarea')->with(['tarea' => $tarea]);
    }

    public function entregarTarea(Request $request, $id_tarea){

    try{
        $tarea              = Tareas::with('proyecto')->findOrFail($id_tarea);
        $tarea->id_tarea    = $id_tarea;
        $tarea->estado_tarea= TAREAS::EN_PROCESO;
        $tarea->url_tarea   = $request->url_tarea;
        $tarea->save();

        $idDocente = $tarea->proyecto->id_docente_lider;


        $DashboardController = new DashboardController();
        $data = $DashboardController->obtenerDashboardData($idDocente);
    
        event(new DashboardUpdated($data));
        
        return response()->json(['mensaje' => 'Tarea entregada correctamente']);

    } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}
