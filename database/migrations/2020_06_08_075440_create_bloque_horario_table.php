<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloqueHorarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloque_horario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hora_inicio');
            $table->string('hora_fin');
            $table->tinyInteger('estado');
            /*$table->timestamps();*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bloque_horario');
    }
}
