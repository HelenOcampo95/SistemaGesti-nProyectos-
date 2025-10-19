<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $primaryKey = 'id_proyecto';
    public $incrementing = true;
    protected $table = 'sgp.proyecto';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'id_proyecto',
        'nombre_proyecto',
        'descripcion_proyecto',
        'fecha_inicio',
        'fecha_entrega',
        'estado_proyecto',
        'id_usuario',
        'id_categoria',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'id_categoria', 'id_categoria');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id_usuario');
    }

}
