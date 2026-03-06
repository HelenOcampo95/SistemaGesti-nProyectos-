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
    const FINALIZADO = 'Finalizado';
    const ACTIVO     = 'Activo';

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
    
    protected $appends = ['porcentaje_avance'];

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'id_categoria', 'id_categoria');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id_usuario');
    }

    public function tareas()
    {
        return $this->hasMany(Tareas::class, 'id_proyecto', 'id_proyecto');
    }
    public function director()
    {
        return $this->belongsTo(Usuarios::class, 'id_docente_director', 'id_usuario');
    }
    public function lider()
    {
        return $this->belongsTo(Usuarios::class, 'id_docente_lider', 'id_usuario');
    }
    public function participantes()
    {
        return $this->belongsToMany(Usuarios::class, 'participantes_proyecto', 'id_proyecto', 'id_usuario');
    }
    public function versiones()
    {
        // 'id_proyecto' es la llave foránea en la tabla versiones
        return $this->hasMany(Versiones::class, 'id_proyecto', 'id_proyecto');
    }
    // Esto hace que el dato se incluya en el JSON para Vue

    public function getPorcentajeAvanceAttribute()
    {
        // Si el proyecto no tiene tareas, el avance es 0
        if ($this->tareas->isEmpty()) {
            return 0;
        }

        // Calculamos el promedio de la columna 'porcentaje_avance' de la tabla tareas
        return round($this->tareas->avg('porcentaje_avance'), 1);
    }
}
