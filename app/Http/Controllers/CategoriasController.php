<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoriasController extends Controller
{
    public function verCategorias()
    {
        return view('categorias.categorias');
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
}
