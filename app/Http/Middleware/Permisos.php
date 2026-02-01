<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Permisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permisos)
{
    // 1. Verificar si el usuario está autenticado
    if (!Auth::check()) {
        return redirect('/login');
    }

    // 2. Verificar si tiene alguno de los permisos
    // Usamos hasAnyPermission de Spatie
    if (!$request->user()->hasAnyPermission($permisos)) {
        abort(403, 'No tienes los permisos necesarios.');
    }

    return $next($request);
}       
}
