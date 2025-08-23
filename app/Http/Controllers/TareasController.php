<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TareasController extends Controller
{
    public function verTareas(){
        return view('tareas.tareas');
    }
}
