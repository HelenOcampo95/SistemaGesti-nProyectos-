<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proyectos\RegistrarProyectoRequest;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function verProyecto(){
        return view('proyecto.proyecto');
    }

    public function CrearProyecto(RegistrarProyectoRequest $request){

        $proyecto                       = new Proyecto();
        $proyecto->nombre_proyecto      = $request->nombre_proyecto;
        $proyecto->descripcion_proyecto = $request->descripcion_proyecto;
        $proyecto->fecha_inicio         = $request->fecha_inicio;
        $proyecto->fecha_entrega        = $request->fecha_entrega;
        $proyecto->estado_proyecto      = $request->estado_proyecto;
        $proyecto->id_usuario           = $request->id_usuario;
        $proyecto->id_categoria         = $request->id_categoria;
        $proyecto->save();

        return redirect()->route('proyecto.proyecto')->with('success', 'Proyecto registrado correctamente.');
    }
}
