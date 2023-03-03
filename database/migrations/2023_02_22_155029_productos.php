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
            $table->string('sku');
            $table->string('externo');
            $table->string('producto');
            $table->string('grupo');
            $table->string('seccion')->nullable();
            $table->string('clasificacion')->nullable();
            $table->string('proveedor')->nullable();
            $table->string('estilo')->nullable();
            $table->string('color')->nullable();
            $table->string('talla')->nullable();
            $table->string('marca')->nullable();
            $table->float('inventario_costo')->nullable();
            $table->float('inventario_venta')->nullable();
            $table->dateTime('ultimo_movimiento')->nullable();
            $table->dateTime('ultima_venta')->nullable();
            $table->dateTime('ultima_recepcion')->nullable();
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
