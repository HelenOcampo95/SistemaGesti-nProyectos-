<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proyectos\RegistrarProyectoRequest;
use App\Models\Categorias;
use App\Models\Proyecto;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
{
    //Vista de proyecto
    public function verProyecto(){
        
        $proyectos = Proyecto::all();

        return view('proyecto.proyecto')->with(['proyectos' => $proyectos]);
    }

    //Registrar el proyecto.
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

        // Agregar colaboradores si vienen en el request
            if ($request->has('colaboradores')) {
                foreach ($request->colaboradores as $correo_usuario) {
                    // Buscar usuario por correo o crearlo
                    $usuario = Usuarios::firstOrCreate(
                        ['correo' => $correo_usuario],
                        ['nombre' => 'Nombre temporal'] // opcional
                    );

                    // Insertar en la tabla usuarios_proyecto con el correo
                    DB::table('usuarios_proyecto')->insert([
                        'id_usuario' => $usuario->id_usuario,
                        'id_proyecto' => $proyecto->id_proyecto,
                        'correo_usuario' => $correo_usuario
                    ]);
                }
            }

            return response()->json('Proyecto creado correctamente', 200);

        } catch (\Exception $e) {
            return response()->json('Error al procesar la información: ' . $e->getMessage(), 422);
        }
    }

    //Select:Listar todos los usuarios.
    public function traerUsuario(Request $request){
        $usuario = Usuarios::select('id_usuario', 'nombre_usuario')
            ->where(function($query) use ($request){
                $query->where('nombre_usuario', 'like', '%'. $request->busqueda. '%');
            })
            ->limit(50)
            ->get();
            return response()->json($usuario, 200);
    }

    //Select:Listar todas las categorias.
    public function traerCategoria(Request $request){
    $categoria = Categorias::select('id_categoria', 'nombre_categoria')
            ->where(function ($query) {
                $query->whereNull('eliminado_en')
                    ->orWhere('eliminado_en', '0000-00-00 00:00:00');
            })
            ->where('nombre_categoria', 'like', '%'. $request->busqueda. '%')
            ->limit(50)
            ->get();

    return response()->json($categoria, 200);

    }

    //Detalle del proyecto por Id.
    public function detalleProyecto($id_proyecto)
    {
        $proyecto = Proyecto::with('categoria', 'usuario')->findOrFail($id_proyecto);
        return view('proyecto.detalle_proyecto', compact('proyecto'));
    }

    //Actualizar información del proyecto.
    public function actualizarProyecto(Request $request)
    {
        try {
            $proyecto                       = Proyecto::where('id_proyecto', $request->id_proyecto)->firstOrFail();
            $proyecto->nombre_proyecto      = $request->nombre_proyecto; 
            $proyecto->descripcion_proyecto = $request->descripcion_proyecto;
            $proyecto->save();

            return response()->json('Proyecto actualizado correctamente', 200);

        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Error al procesar la información',
                'detalle' => $e->getMessage(),
                'linea'   => $e->getLine(),
                'archivo' => $e->getFile(),
            ], 500);
        }
    }

    public function selectProyecto(Request $request){
        $proyecto = Proyecto::select('id_proyecto', 'nombre_proyecto')
            ->where(function($query) use ($request){
                $query->where('nombre_proyecto', 'like', '%'. $request->busqueda. '%');
            })
            ->limit(50)
            ->get();
            return response()->json($proyecto, 200);
    }

}
