<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

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

    public function verUsuarios(){
        return view('usuarios.usuarios');
    }

    public function listarUsuarios(Request $request){ 

    $usuarios = Usuarios::query();

        return DataTables::eloquent($usuarios)
            ->addColumn('nombre_usuario', fn($c) => $c->nombre_usuario ?? 'Sin nombre')
            ->addColumn('apellido_usuario', fn($c) => $c->apellido_usuario ?? 'Sin apellido')
            ->addColumn('cedula', fn($c) => $c->cedula ?? 'Sin cédula')
            ->addColumn('correo_usuario', fn($c) => $c->correo_usuario ?? 'Sin usuario')
            ->filter(function ($query) use ($request) {
                $buscar = $request->input('buscar');
                if (!empty($buscar)) {
                    $query->where('nombre_usuario', 'like', "%{$buscar}%")
                    ->orWhere('apellido_usuario', 'like', "%{$buscar}%")
                    ->orWhere('cedula', 'like', "%{$buscar}%")
                    ->orWhere('correo_usuario', 'like', "%{$buscar}%");
                }
            })
        ->toJson();

    }
}
