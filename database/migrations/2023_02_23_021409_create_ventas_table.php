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
            $table->integer("descuento_actual")->nullable();
            $table->float("pvp_factura", 8, 2)->nullable();
            $table->float("pvp", 8, 2)->nullable();
            $table->float("pvp_mayorista", 8, 2)->nullable();
            $table->string("punto_operacion")->nullable();
            $table->date("fecha")->nullable();
            $table->time("hora")->nullable();
            $table->string("vendedor")->nullable();
            $table->string("cajero")->nullable();
            $table->string("tipo")->nullable();
            $table->string("transaccion")->nullable();
            $table->integer("cantidad")->nullable();
            $table->float("costo", 8, 2)->nullable();
            $table->float("subtotal", 8, 2)->nullable();
            $table->float("por_descuento_manual")->nullable();
            $table->float("por_descuento_sistema")->nullable();
            $table->float("por_descuento")->nullable();
            $table->float("descuento_manual")->nullable();
            $table->float("descuento_sistema")->nullable();
            $table->float("descuento")->nullable();
            $table->float("venta_neta", 8, 2)->nullable();
            $table->float("impuesto", 8, 2)->nullable();
            $table->float("total", 8, 2);
            $table->float("utilidad", 8, 2)->nullable();
            $table->float("gm",8,2)->nullable();
            $table->float("efectivo", 8, 2)->nullable();
            $table->float("tarjeta_credito", 8, 2)->nullable();
            $table->float("tarjeta_debito", 8, 2)->nullable();
            $table->float("nota_credito", 8, 2)->nullable();
            $table->float("cupo_credito", 8, 2)->nullable();
            $table->float("cheque", 8, 2)->nullable();
            $table->float("otros", 8, 2)->nullable();            
            $table->float("devolucion", 8, 2)->nullable();            
            $table->float("medianet", 8, 2)->nullable();            
            $table->float("datafast", 8, 2)->nullable();            
            $table->float("austro", 8, 2)->nullable();            
            $table->float("visa", 8, 2)->nullable();            
            $table->float("mastercard", 8, 2)->nullable();            
            $table->float("american_express", 8, 2)->nullable();            
            $table->float("diners", 8, 2)->nullable();            
            $table->float("discovery", 8, 2)->nullable();            
            $table->float("pacificard", 8, 2)->nullable();            
            $table->float("bankcard", 8, 2)->nullable();            
            $table->float("alia", 8, 2)->nullable();            
            $table->float("otras_tarjetas", 8, 2)->nullable();            
            $table->float("banco_pichincha", 8, 2)->nullable();         
            $table->float("banco_pacifico", 8, 2)->nullable();            
            $table->float("banco_guayaquil", 8, 2)->nullable();            
            $table->float("banco_bolivariano", 8, 2)->nullable();            
            $table->float("banco_produbanco", 8, 2)->nullable();            
            $table->float("banco_austro", 8, 2)->nullable();            
            $table->float("banco_internacional", 8, 2)->nullable();            
            $table->float("banco_solidario", 8, 2)->nullable();            
            $table->float("banco_machala", 8, 2)->nullable();            
            $table->float("otros_bancos", 8, 2)->nullable();
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
