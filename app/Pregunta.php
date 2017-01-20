<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';


    public function obtenerRequisitos()
    {
        return $this->belongsTo('App\Requisito', 'idRequisito', 'id')->with('obtenerDimensiones');
    }
}
