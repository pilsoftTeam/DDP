<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idRequisito');
            $table->integer('ordenPreguntas');
            $table->foreign('idRequisito')->references('id')->on('requisitos');
            $table->longText('pregunta');
            $table->longText('tecnicaAuditoria');
            $table->boolean('escrita');
            $table->boolean('numeral');
            $table->boolean('documental');
            $table->boolean('estado');
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
        Schema::dropIfExists('preguntas');
    }
}
