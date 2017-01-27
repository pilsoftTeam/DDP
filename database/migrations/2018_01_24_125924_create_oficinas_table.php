<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOficinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficinas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idComuna');
            $table->foreign('idComuna')->references('id')->on('comunas');
            $table->string('zona');
            $table->string('numeroLlamadoInterno');
            $table->string('numeroZonaLicitacion');
            $table->string('direccion');
            $table->string('fono');
            $table->string('email');
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
        Schema::dropIfExists('oficinas');
    }
}
