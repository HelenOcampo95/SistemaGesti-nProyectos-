<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tareas extends Model
{
    use HasFactory;
    public $incrementing = true;
    protected $table = 'sgp.tareas';
    protected $primaryKey = 'id_tarea'; 
    
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';


    protected $fillable = [
        'descripcion_tarea',
        'fecha_entrega',
        'estadoo_tarea',
        'observaciones_docente',
        'porcentaje_avance'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }

}
