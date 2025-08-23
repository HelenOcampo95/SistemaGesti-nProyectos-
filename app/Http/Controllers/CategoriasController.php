<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function verCategorias(){
        return view('categorias.categorias');
    }
}
