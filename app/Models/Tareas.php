<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\PendingSingletonResourceRegistration;

class Tareas extends Model
{
    use HasFactory;
    public $incrementing = true;
    protected $table = 'sgp.tareas';
    protected $primaryKey = 'id_tarea'; 
    
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    const DELETED_AT = 'eliminado_en';
    const ENTREGADAS = 'Entregadas'; //tareas en proceso
    const FINALIZADAS= 'Finalizada';
    const ASIGNADA   = 'Asignada'; // tareas pendientes
    const CORREGIR   = 'Corregir';
    


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
    public static function getEstados() {
        return [
            self::FINALIZADAS,
            self::CORREGIR,
        ];
    }
    

}
