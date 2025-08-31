<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{

    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = true;
    protected $table = 'sgp.usuarios';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
}
