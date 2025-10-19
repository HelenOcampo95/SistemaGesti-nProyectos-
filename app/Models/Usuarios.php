<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Usuarios extends Authenticatable
{

    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = true;
    protected $table = 'sgp.usuarios';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre_usuario',
        'apellido_usuario',
        'cedula',
        'correo_usuario',
        'contrasena_usuario',
        'id_rol',
    ];

    protected $hidden = [
        'contrasena_usuario',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena_usuario;
    }
}
