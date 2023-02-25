<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = ['sku', 'externo', 'producto', 'grupo', 'seccion', 'clasificacion', 'proveedor', 'estilo', 'color', 'talla', 'marca', 'inventario_costo', 'inventario_venta', 'ultimo_movimiento', 'ultima_venta', 'ultima_recepcion'];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
