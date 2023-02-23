<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Productos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sku');
            $table->integer('externo');
            $table->string('producto');
            $table->string('grupo');
            $table->string('seccion');
            $table->string('clasificacion');
            $table->string('proveedor');
            $table->string('estilo');
            $table->string('color');
            $table->string('talla');
            $table->string('marca');
            $table->float('inventario_costo');
            $table->float('inventario_venta');
            $table->dateTime('ultimo_movimiento');
            $table->dateTime('ultima_venta');
            $table->dateTime('ultima_recepcion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
