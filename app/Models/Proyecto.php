<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = true;
    protected $table = 'sgp.proyecto';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre_proyecto',
        'descripcion_proyecto',
        'fecha_inicio',
        'fecha_entrega',
        'estado_proyecto',
        'id_usuario',
        'id_categoria',
    ];

}
