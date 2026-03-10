<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Events\NotificacionUsuario;
use App\Models\Proyecto;
use App\Models\Versiones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use const Ratchet\VERSION;

class VersionesController extends Controller
{
    public function verVersion($id_Version){
        $version = Versiones::findOrFail($id_Version);
        return view('version.ver_version')->with(['version' => $version]);
    }

    public function aceptarVersion(Request $request, $id_version){

        DB::beginTransaction();

        try {
            $version = Versiones::findOrFail($id_version);
            $version->estado_version = Versiones::ACEPTADA;
            $version->save();

            DB::commit();
            return back()->with('success', 'Versión actualizada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function rechazarVersion(Request $request, $id_version){
        DB::beginTransaction();

        try {
            $version = Versiones::findOrFail($id_version);
            $version->estado_version = Versiones::RECHAZADA;
            $version->save();

            DB::commit();
            return back()->with('success', 'Versión actualizada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function registrarVersion(Request $request, $id_proyecto) {
            $request->validate([
            'version' => 'required|string|max:20',
            'descripcion_cambios' => 'required|string|max:500',
            'archivos_relacionados' => 'nullable|string|max:255'
        ]);

        DB::beginTransaction();

        try {

            $version = new Versiones();

            $version->id_proyecto           = $id_proyecto;
            $version->version               = $request->version;
            $version->descripcion_cambios   = $request->descripcion_cambios;
            $version->fecha_modificacion    = now();
            $version->archivos_relacionados = $request->archivos_relacionados;
            $version->estado_version        = Versiones::PENDIENTE;
            $version->save();

            $version = Versiones::with('proyecto')
            ->where('id_proyecto', $id_proyecto)
            ->first();

            $id_docente = $version->proyecto->id_docente_lider;
            $notificacion = \App\Models\Notificacion::create([
                'id_usuario'                => $id_docente,
                'tipo_notificacion'         => 'version',
                'id_referencia'             => $version->id_version,
                'titulo_notificacion'       => 'Nueva versión',
                'descripcion_notificacion'  => "El equipo ha entregado una nueva versión",
                'url_notificacion'          => "/version/{$version->id_version}", 
                'leida'                     => 0
            ]);

            $DashboardController = new DashboardController();
            $data = $DashboardController->obtenerDashboardData($id_docente);
            $dataLimpia = json_decode(json_encode($data), true); 

            event(new DashboardUpdated($dataLimpia));
            event( new NotificacionUsuario($notificacion));

            DB::commit();

            return response()->json(['message' => 'Versión registrada'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => 'Error al registrar',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
