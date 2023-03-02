<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $fillable = [
        'tienda', 'producto','cantidad'
    ];
    public $timestamps = false;
}
