<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versiones extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $table = 'sgp.versiones';
    protected $primaryKey = 'id_version'; 
    
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    const RECHAZADA  = 'Rechazada';
    const ACEPTADA   = 'Aceptada';
    const PENDIENTE  = 'Pendiente';
    
    public function proyecto() {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
    public function esPendiente()
    {
        return $this->estado_version === self::PENDIENTE;
    }
}
