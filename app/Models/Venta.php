<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'tienda_id',
        'cliente_id',
        'division',
        'departamento',
        'producto_id',
        'descuento_actual',
        'pvp_factura',
        'pvp',
        'pvp_mayorista',
        'punto_operacion',
        'fecha',
        'hora',
        'vendedor',
        'cajero',
        'tipo',
        'transaccion',
        'cantidad',
        'costo',
        'subtotal',
        'descuento_manual',
        'descuento_sistema',
        'descuento',
        'venta_neta',
        'impuesto',
        'total',
        'utilidad',
        'gm',
        'efectivo',
        'tarjeta_credito',
        'tarjeta_debito', 
        'nota_credito', 
        'cupo_credito', 
        'cheque', 
        'otros', 
        'devolucion', 
        'medianet', 
        'datafast', 
        'austro', 
        'visa', 
        'mastercard', 
        'american_express',
        'diners',
        'discover',
        "pacificard",            
        "bankcard",            
        "alia",            
        "otras_tarjetas",            
        "banco_pichincha",            
        "banco_pacifico",            
        "banco_guayaquil",            
        "banco_bolivariano",            
        "banco_produbanco",            
        "banco_austro",            
        "banco_internacional",            
        "banco_solidario",            
        "banco_machala",            
        "otros_bancos",
    ];

    public $with = ['cliente', 'tienda', 'producto'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function tienda()
    {
        return $this->belongsTo(Tienda::class, 'tienda_id', 'id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }
}
