<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $table = 'sgp.categoria_proyectos';
    protected $primaryKey = 'id_categoria'; 
    
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    const DELETED_AT = 'eliminado_en';


    protected $fillable = [
        'nombre_categoria',
        'descripcion_categoria',
    ];

}
