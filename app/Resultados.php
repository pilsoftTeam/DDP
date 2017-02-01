<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultados extends Model
{
    protected $table = 'resultados';


    public function traerPreguntas()
    {
        return $this->belongsTo('App\Pregunta', 'idPregunta', 'id')->with('obtenerRequisitos');
    }

    public function getPreguntas()
    {
        return $this->belongsTo('App\Pregunta', 'idPregunta', 'id');
    }
}
