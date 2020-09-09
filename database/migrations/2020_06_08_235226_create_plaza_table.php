<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlazaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plaza', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->tinyInteger('estado');
            $table->bigInteger('cantidad');
            // $table->string('tipo')->nullable();
            // $table->string('descripcion')->nullable();
            // $table->string('img')->nullable();
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
        Schema::dropIfExists('plaza');
    }
}
