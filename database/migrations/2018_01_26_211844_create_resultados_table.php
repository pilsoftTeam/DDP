<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idAsignacion');
            $table->foreign('idAsignacion')->references('id')->on('asignaciones');
            $table->unsignedInteger('idPregunta');
            $table->foreign('idPregunta')->references('id')->on('preguntas');
            $table->boolean('cumplimiento');
            $table->integer('observacionNumeral')->nullable();
            $table->integer('observacionEscrita')->nullable();
            $table->longText('rutaObservacionDocumental')->nullable();
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
        Schema::dropIfExists('resultados');
    }
}
