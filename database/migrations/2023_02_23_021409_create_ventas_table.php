<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("tienda_id");
            $table->foreign('tienda_id')->references('id')->on('tiendas');
            $table->unsignedBigInteger("cliente_id");
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->string("division");
            $table->string("departamento");
            $table->unsignedBigInteger("producto_id");
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->integer("descuento_actual");
            $table->float("pvp_factura", 8, 2);
            $table->float("pvp", 8, 2);
            $table->float("pvp_mayorista", 8, 2);
            $table->string("punto_operacion");
            $table->date("fecha");
            $table->time("hora");
            $table->string("vendedor");
            $table->string("cajero");
            $table->string("tipo");
            $table->string("transaccion");
            $table->integer("cantidad");
            $table->float("costo", 8, 2);
            $table->float("subtotal", 8, 2);
            $table->integer("descuento_manual");
            $table->integer("descuento_sistema");
            $table->integer("descuento");
            $table->float("venta_neta", 8, 2);
            $table->float("impuesto", 8, 2);
            $table->float("total", 8, 2);
            $table->float("utilidad", 8, 2);
            $table->integer("gm");
            $table->float("efectivo", 8, 2);
            $table->float("tarjeta_credito", 8, 2);
            $table->float("tarjeta_debito", 8, 2);
            $table->float("nota_credito", 8, 2);
            $table->float("cupo_credito", 8, 2);
            $table->float("cheque", 8, 2);
            $table->float("otros", 8, 2);            
            $table->float("devolucion", 8, 2);            
            $table->float("medianet", 8, 2);            
            $table->float("datafast", 8, 2);            
            $table->float("austro", 8, 2);            
            $table->float("visa", 8, 2);            
            $table->float("mastercard", 8, 2);            
            $table->float("american_express", 8, 2);            
            $table->float("diners", 8, 2);            
            $table->float("discovery", 8, 2);            
            $table->float("pacificard", 8, 2);            
            $table->float("bankcard", 8, 2);            
            $table->float("alia", 8, 2);            
            $table->float("otras_tarjetas", 8, 2);            
            $table->float("banco_pichincha", 8, 2);            
            $table->float("banco_pacifico", 8, 2);            
            $table->float("banco_guayaquil", 8, 2);            
            $table->float("banco_bolivariano", 8, 2);            
            $table->float("banco_produbanco", 8, 2);            
            $table->float("banco_austro", 8, 2);            
            $table->float("banco_internacional", 8, 2);            
            $table->float("banco_solidario", 8, 2);            
            $table->float("banco_machala", 8, 2);            
            $table->float("otros_bancos", 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
