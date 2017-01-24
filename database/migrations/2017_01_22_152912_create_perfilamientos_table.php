<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfilamientos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idPerfil');
            $table->foreign('idPerfil')->references('id')->on('perfiles');
            $table->unsignedInteger('idUsuario');
            $table->foreign('idUsuario')->references('id')->on('usuarios');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
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
        Schema::dropIfExists('perfilamientos');
    }
}
