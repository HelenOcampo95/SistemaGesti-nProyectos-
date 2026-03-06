<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $primaryKey = 'id_notificacion';
    public $incrementing = true;
    protected $table = 'sgp.notificaciones';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'id_usuario',
        'tipo_notificacion',
        'id_referencia',
        'titulo_notificacion',
        'descripcion_notificacion',
        'url_notificacion',
        'leida'
    ];
}
