<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function getNotificaciones()
    {
        $notificaciones = Notificacion::where('id_usuario', auth()->id())
            ->orderBy('actualizado_en', 'desc')
            ->take(10)
            ->get();

        $noLeidas = Notificacion::where('id_usuario', auth()->id())
            ->where('leida', 0)
            ->count();

        return response()->json([
        'notificaciones' => $notificaciones, // Enviamos la colección, no el HTML
        'count' => $noLeidas
    ]);
    }

    public function marcarComoLeida($id_notificacion)
    {
        // Buscamos específicamente por tu columna de ID personalizada
        $notificacion = Notificacion::where('id_notificacion', $id_notificacion)
                                    ->where('id_usuario', auth()->id())
                                    ->first();

        if ($notificacion) {
            $notificacion->leida = 1;
            $notificacion->save(); // Usar save() a veces salta bloqueos de fillable si el modelo está mal configurado
            
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'No encontrada'], 404);
    }
}
