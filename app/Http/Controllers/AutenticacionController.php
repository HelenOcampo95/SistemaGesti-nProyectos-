<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Models\Categorias;
use App\Models\Role;
use App\Models\Usuarios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AutenticacionController extends Controller
{
    public function vistaRegistrarme()
    { 
        $roles = Role::all();

        return view('iniciar_sesion.registrarme', compact('roles'));
    }


    public function iniciarSesion(Request $request)
    {
        
        $request->validate([
            'correo_usuario' => 'required|email',
            'contrasena_usuario' => 'required|min:6',
        ]);

        $credenciales = [
            'correo_usuario' => $request->correo_usuario,
            'password' => $request->contrasena_usuario, 
        ];

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            $intended = session()->pull('url.intended'); 
            $redirectTo = $intended ?: route('dashboard');

            if (url()->previous() === route('login')) {
                $redirectTo = route('dashboard');
            }

            return response()->json([
                'mensaje'     => 'Inicio de sesión exitoso',
                'usuario'     => Auth::user(),
                'redireccion' => $redirectTo,
            ], 200)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }   
    }

    public function registrarme(Request $request)
    {
        // Si falla, Laravel devuelve 422 con los errores (no lo atrapes)
        $request->validate([
            'nombre_usuario'     => ['required','string','max:255'],
            'apellido_usuario'   => ['required','string','max:255'],
            'cedula'             => ['required','string','max:50', 'unique:usuarios,cedula'],
            'correo_usuario'     => ['required','email', 'max:255', 'unique:usuarios,correo_usuario'],
            'contrasena_usuario' => ['required','string','min:6'], // opcional: 'confirmed'
            'id_rol'             => ['required'],
        ]);

        try {
            $usuarioCreado = DB::transaction(function() use ($request) {
                $usuario = Usuarios::create([
                    'nombre_usuario'      => $request->nombre_usuario,
                    'apellido_usuario'    => $request->apellido_usuario,
                    'cedula'              => $request->cedula,
                    'correo_usuario'      => $request->correo_usuario,
                    'contrasena_usuario'  => Hash::make($request->contrasena_usuario),
                ]);
                $usuario->assignRole($request->id_rol);
                return $usuario;
            });

            DB::commit();
            
            $DashboardController = new DashboardController();
            $data = $DashboardController->obtenerDashboardData($usuarioCreado->id_usuario);

            $dataLimpia = json_decode(json_encode($data), true); 

            event(new DashboardUpdated($dataLimpia));

            // Ahora sí, logueamos al usuario para que pueda entrar al sistema
            Auth::login($usuarioCreado);

    return response()->json(['message' => 'Registrado correctamente'], 200);
                
            return response()->json(['message' => 'El usuario se ha creado correctamente'], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error al registrar el usuario',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Artisan::call('optimize:clear');
        
        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'redirect' => route('login')
            ]);
        }

        return redirect()->route('login');
    }


}