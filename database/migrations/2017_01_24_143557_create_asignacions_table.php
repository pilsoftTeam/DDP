<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idUsuarioAsignado');
            $table->foreign('idUsuarioAsignado')->references('id')->on('usuarios');
            $table->unsignedInteger('idUsuarioAsignador');
            $table->foreign('idUsuarioAsignador')->references('id')->on('usuarios');
            $table->unsignedInteger('idOficinaAsignada');
            $table->foreign('idOficinaAsignada')->references('id')->on('oficinas');
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
        Schema::dropIfExists('asignaciones');
    }
}
