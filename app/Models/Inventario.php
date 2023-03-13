<?php

namespace App\Models;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventarios';

    protected $fillable = [
        'tienda', 'producto','cantidad', 'fecha_corte'
    ];
    
    public $timestamps = false;

}
