<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proyectos\RegistrarProyectoRequest;
use App\Models\Categorias;
use App\Models\Proyecto;
use App\Models\Usuarios;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function verProyecto(){
        return view('proyecto.proyecto');
    }

    public function registrarProyecto(Request $request){
        
        try {
        $proyecto = new Proyecto();
        $proyecto->nombre_proyecto = $request->nombre_proyecto;
        $proyecto->descripcion_proyecto = $request->descripcion_proyecto;
        $proyecto->fecha_inicio = $request->fecha_inicio;
        $proyecto->fecha_entrega = $request->fecha_entrega;
        $proyecto->estado_proyecto = $request->estado_proyecto;
        $proyecto->id_categoria = $request->id_categoria;
        $proyecto->id_usuario = $request->id_usuario;
        $proyecto->save();

        return response()->json('Proyecto creado correctamente', 200);

        } catch (\Exception $e) {
            return response()->json('Error al procesar la información: ' . $e->getMessage(), 422);
        }
    }

    public function traerUsuario(Request $request){
        $usuario = Usuarios::select('id_usuario', 'nombre_usuario')
            ->where(function($query) use ($request){
                $query->where('nombre_usuario', 'like', '%'. $request->busqueda. '%');
            })
            ->limit(50)
            ->get();
            return response()->json($usuario, 200);
    }

    public function traerCategoria(Request $request){
        $categoria = Categorias::select('id_categoria', 'nombre_categoria')
            ->where(function($query) use ($request){
                $query->where('nombre_categoria', 'like', '%'. $request->busqueda. '%');
            })
            ->limit(50)
            ->get();
            return response()->json($categoria, 200);
    }
}
