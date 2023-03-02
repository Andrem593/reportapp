<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = ['sku',
    'externo', 
    'producto', 
    'grupo', 
    'seccion', 
    'clasificacion', 
    'proveedor', 
    'estilo', 
    'color', 
    'talla', 
    'marca', 
    'inventario_costo', 
    'inventario_venta', 
    'ultimo_movimiento', 
    'ultima_venta', 
    'ultima_recepcion'];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
