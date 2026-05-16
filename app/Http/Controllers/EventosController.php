<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Eventos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EventosController extends Controller
{
    public function verEventos(){
        return view('eventos.eventos');
    }

    public function registrarEvento(Request $request){

        DB::beginTransaction();
        
        try {

        $evento                     = New Eventos();
        $evento->nombre_evento      = $request->nombre_evento;
        $evento->fecha_evento       = $request->fecha_evento;
        $evento->hora_evento        = $request->hora_evento;
        $evento->modalidad_evento   = $request->modalidad_evento;
        $evento->ubicacion_url      = $request->ubicacion_url;
        $evento->id_usuario         = Auth::id();
        $evento->id_categoria       = $request->id_categoria;
        $evento->save();
        
        DB::commit();

        return response()->json(['mensaje' => 'Evento creado con éxito', 'id' => $evento->id_evento], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al registrar', 'evento' => $e->getMessage()], 422);
        }
    
    }
    public function listaEventos(Request $request)
    {
        $eventos = Eventos::query();

        return DataTables::eloquent($eventos)
            ->addColumn('nombre_evento', fn($c) => $c->nombre_evento ?? 'Sin nombre')
            ->addColumn('fecha_evento', fn($c) => $c->fecha_evento ?? 'Sin fecha')
            ->addColumn('hora_evento', fn($c) => $c->hora_evento ?? 'Sin hora')
            ->addColumn('modalidad_evento', fn($c) => $c->modalidad_evento ?? 'Sin modalidad')
            ->addColumn('ubicacion_url', fn($c) => $c->ubicacion_url ?? 'Sin lugar')
            ->filter(function ($query) use ($request) {
                $buscar = $request->input('buscar');
                if (!empty($buscar)) {
                    $query->where('nombre_evento', 'like', "%{$buscar}%")
                    ->orWhere('modalidad_evento', 'like', "%{$buscar}%");
                }
            })
        ->toJson();
    }

    public function verCategorias(Request $request){
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

    public function actualizarEvento(Request $request, $id_evento){
        try{
            $evento                          = Eventos::findOrFail($id_evento);
            $evento->nombre_evento           = $request->nombre_evento; 
            $evento->save();

            return response()->json('Evento actualizado correctamente', 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al procesar la información',
                'detalle' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile(),
            ], 500);
        }
    }

    public function eliminarEvento($id_evento){
        try {
            $evento                  = Eventos::findOrFail($id_evento);
            $evento->eliminado_en    = Carbon::now();;
            $evento->save();

            return response()->json([
                'message' => 'Evento eliminado correctamente'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Evento no encontrado'
            ], 404);
        } catch (\Illuminate\Database\QueryException $e) {
            // Esto captura errores por llaves foráneas
            return response()->json([
                'error' => 'No se puede eliminar el evento porque tiene registros asociados'
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }
    
}