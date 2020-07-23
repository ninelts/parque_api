<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('estado_reserva');
            $table->bigInteger('plaza_id')->unsigned()->index();
            $table->bigInteger('usuario_id')->unsigned()->index();
            $table->bigInteger('bloque_horario_id')->unsigned()->index();
            $table->bigInteger('codigo_qr_id')->unsigned()->index();
            $table->dateTime('fecha_de_reserva');
            $table->datetime('activacion_reserva');
            $table->datetime('expiracion_reserva');
            $table->timestamps();
            // $table->tinyInteger('codigo_qr_id')->nullable();//Temporalr

            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('codigo_qr_id')->references('id')->on('codigo_qr');
            $table->foreign('plaza_id')->references('id')->on('plaza');
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
        Schema::dropIfExists('reservas');
    }
}
