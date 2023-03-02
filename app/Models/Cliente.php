<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'identificacion', 'nombres','genero',
        'correo', 'telefono', 'telefono2',
        'direccion', 'fecha_nacimiento'
    ];
    public $timestamps = false;
}
