<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole; // Clase base de Spatie
use Illuminate\Database\Eloquent\Model; // Importación estándar

// Es OBLIGATORIO extender SpatieRole para resolver el TypeError
class Role extends SpatieRole 
{
    // Sobreescribe solo la configuración de tu tabla
    protected $table = 'sgp.roles'; 
    protected $primaryKey = 'id'; 
    // ...
}