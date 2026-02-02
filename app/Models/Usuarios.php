<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Usuarios extends Authenticatable
{

    use HasFactory, Notifiable, HasRoles;

    protected $keyType = 'int';
    public $incrementing = true;
    protected $table = 'sgp.usuarios';
    protected $primaryKey = 'id_usuario'; 
    protected $guard_name = 'web'; 
    public $primaryRoleColumn = 'id_rol';


    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre_usuario',
        'apellido_usuario',
        'cedula',
        'correo_usuario',
        'contrasena_usuario',
        
    ];

    protected $hidden = [
        'contrasena_usuario',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena_usuario;
    }

    public function username()
    {
        return 'correo_usuario';
    }
    public function getAuthIdentifierName()
    {
        return 'id_usuario';
    }

    public function getIdAttribute()
    {
        return $this->id_usuario;
    }
}
