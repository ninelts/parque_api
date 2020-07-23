<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloqueReservasPlazaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloque_reservas_plaza', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('estado');
            $table->tinyInteger('disponible');
            $table->bigInteger('plaza_id')->unsigned()->index();
            $table->bigInteger('bloque_horario_id')->unsigned()->index();
            $table->bigInteger('precios_id')->unsigned()->index();
            $table->bigInteger('cantidad')->unsigned()->index();
            $table->date('fecha');
            $table->timestamps();
            $table->foreign('plaza_id')->references('id')->on('plaza');
            $table->foreign('precios_id')->references('id')->on('precios');
            $table->foreign('bloque_horario_id')->references('id')->on('bloque_horario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bloque_reservas_plaza');
    }
}
