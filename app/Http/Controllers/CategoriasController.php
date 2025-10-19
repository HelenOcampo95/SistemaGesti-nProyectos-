<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoriasController extends Controller
{
    public function verCategorias()
    {
        $categorias = Categorias::all();
        return view('categorias.categorias', compact('categorias'));
    }

    public function listaCategorias(Request $request)
    {
        $categorias = Categorias::query();

    return DataTables::eloquent($categorias)
        ->addColumn('nombre_categoria', fn($c) => $c->nombre_categoria ?? 'Sin nombre')
        ->addColumn('descripcion_categoria', fn($c) => $c->descripcion_categoria ?? 'Sin descripción')
        ->filter(function ($query) use ($request) {
            $buscar = $request->input('buscar');
            if (!empty($buscar)) {
                $query->where('nombre_categoria', 'like', "%{$buscar}%")
                    ->orWhere('descripcion_categoria', 'like', "%{$buscar}%");
            }
        })
        ->toJson();
    }


    public function registrarCategoria(Request $request)
    {

        try {
            $categoria                          =  new Categorias();
            $categoria->nombre_categoria        = $request->nombre_categoria;
            $categoria->descripcion_categoria   = $request->descripcion_categoria;
            $categoria->save();

            return response()->json('La categoria se ha creado correctamente', 200);
        } catch (\Exception $e) {
            return response()->json('Error al crear la categoria' . $e->getMessage(), 422);
        }
    }

    public function categoriaPorId($id_categoria)
    {
        $categoria = Categorias::findOrFail($id_categoria);

        
        return response()->json([
            'id_categoria'          => $categoria->id_categoria,
            'nombre_categoria'      => $categoria->nombre_categoria,
            'descripcion_categoria' => $categoria->descripcion_categoria,
        ]); 
    }

    public function actualizarCategoria(Request $request, $id_categoria)
    {
        try{
            $categoria                          = Categorias::findOrFail($id_categoria);
            $categoria->nombre_categoria        = $request->nombre_categoria; 
            $categoria->descripcion_categoria   = $request->descripcion_categoria;
            $categoria->save();

            return response()->json('Proyecto actualizado correctamente', 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al procesar la información',
                'detalle' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile(),
            ], 500);
        }
    }

    //Las categorías se pueden eliminar solo cuando no estén asociadas a un proyecto.
    public function eliminarCategoria(Request $request, $id_categoria){

        try {
            $categoria                  = Categorias::findOrFail($id_categoria);
            $categoria->eliminado_en    = Carbon::now();;
            $categoria->save();

            return response()->json([
                'message' => 'Categoría eliminada correctamente'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Categoría no encontrada'
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
