<?php

namespace App\Http\Controllers;

use App\Models\Tareas;
use Illuminate\Http\Request;
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
            $tarea->save();   
            
            return response()->json('La tarea se ha asignado correctamente', 200);   
        }catch (\Exception $e) {
            return response()->json('Error al asignar la tarea' . $e->getMessage(), 422);
        }
        
    }

    public function listarTareas(Request $request)
    {
        $tareas = Tareas::with('proyecto');

        return DataTables::eloquent($tareas)
            ->addColumn('nombre_proyecto', fn($c) => $c->proyecto->nombre_proyecto ?? 'Sin proyecto')
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
            $tarea                          = Tareas::findOrFail($id_tareas);
            if (!$request->hasAny(['descripcion_tarea', 'observaciones_docente'])) {
                return response()->json([
                    'error' => 'Debe enviar al menos una descripción o una observación'
                ], 422);
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
}
