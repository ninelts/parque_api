<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
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
            $table->bigInteger('bloque_plaza_reserva_id')->unsigned()->index();
            $table->bigInteger('carrito_de_compra_id')->unsigned()->index();
            $table->dateTime('fecha_reserva');
            $table->timestamps();


            $table->foreign('bloque_plaza_reserva_id')->references('id')->on('bloque_reservas_plaza');
            $table->foreign('carrito_de_compra_id')->references('id')->on('carrito_de_compra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cantidad_productos');
    }
}
