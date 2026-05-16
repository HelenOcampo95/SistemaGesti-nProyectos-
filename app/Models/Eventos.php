<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    use HasFactory;

    public $incrementing = true;

    protected $table = 'sgp.eventos';

    protected $primaryKey = 'id_evento';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    const DELETED_AT = 'eliminado_en';

    protected $fillable = [
        'nombre_evento',
        'fecha_evento',
        'hora_evento',
        'modalidad_evento',
        'ubicacion_url'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id_usuario');
    }
    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'id_categoria', 'id_categoria');
    }



}
