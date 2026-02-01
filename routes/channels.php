<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('dashboard.institucional', function ($user) {
    // Todos los usuarios autenticados pueden escuchar este canal
    return $user != null;
});
Broadcast::channel('dashboard.{idDocente}', function ($user, $idDocente) {
    return (int) $user->id_usuario === (int) $idDocente;
});


