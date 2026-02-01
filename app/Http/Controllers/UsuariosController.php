<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    public function selectRol(Request $request){
        $rol = Role::select('id_rol', 'name')
            ->where(function($query) use ($request){
                $query->where('name', 'like', '%'. $request->busqueda. '%');
            })
            ->limite(50)
            ->get();

            return response()->json($rol, 200);
    }
}
