<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaDoResponsable extends Model
{
    use HasFactory;

    public $incrementing    = true;
    protected $table        = "sgp.categoria_docente_responsable";
    protected $primaryKey   = 'id_docente_responsable';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en'; 

    protected $fillable = [
        'id_categoria',
        'id_docente_director',
        'id_docente_lider'
    ];


}
