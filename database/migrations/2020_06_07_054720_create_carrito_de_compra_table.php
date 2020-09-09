<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritoDeCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrito_de_compra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('estado');
            $table->string('cod_carrito_compra', 200)->nullable();
            $table->integer('precio_total');
            $table->integer('cantidad_productos');
            $table->integer('user_id');
            $table->timestamps();

  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carrito_de_compra');
    }
}
