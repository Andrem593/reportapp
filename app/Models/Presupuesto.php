<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table = 'presupuestos';

    protected $fillable = ['tienda_id', 'presupuesto', 'fecha_inicio', 'fecha_fin', 'estado'];    

    public $timestamps = false;

    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda');
    }
}
