<?php

namespace App\Http\Controllers;

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
}
