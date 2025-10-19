<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Usuarios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AutenticacionController extends Controller
{
    public function vistaRegistrarme()
    { 
        return view('iniciar_sesion.registrarme');
    }


    public function iniciarSesion(Request $request)
    {
        // Validar los campos enviados desde el frontend
        $request->validate([
            'correo_usuario' => 'required|email',
            'contrasena_usuario' => 'required|min:6',
        ]);

        // Credenciales de autenticación
        $credenciales = [
            'correo_usuario' => $request->correo_usuario,
            'password' => $request->contrasena_usuario, // el campo de contraseña del formulario
        ];

        // Intentar autenticar
        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            return response()->json([
                'mensaje' => 'Inicio de sesión exitoso',
                'usuario' => Auth::user(),
                'redireccion' => '/welcome',
            ]);
        }

        // Si las credenciales no coinciden
        return response()->json([
            'mensaje' => 'Correo o contraseña incorrectos',
        ], 401);
    }

    public function registrarme(Request $request)
    {
        try {
            $request->validate([
                'nombre_usuario' => 'required|string|max:255',
                'apellido_usuario' => 'required|string|max:255',
                'cedula' => 'required',
                'correo_usuario' => 'required|email|unique:usuarios,correo_usuario',
                'contrasena_usuario' => 'required|min:6',
                'id_rol' => 'required',
            ]);

            $usuario = Usuarios::create([
                'nombre_usuario'    => $request->nombre_usuario,
                'apellido_usuario'  => $request->apellido_usuario,
                'cedula'            => $request->cedula,
                'correo_usuario'    => $request->correo_usuario,
                'contrasena_usuario'=> Hash::make($request->contrasena_usuario),
                'id_rol'            => $request->id_rol,
            ]);

            Auth::login($usuario);

            return response()->json('El usuario se ha creado correctamente', 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al registrar el usuario',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}