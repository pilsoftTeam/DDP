<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{
    protected $table = 'requisitos';


    public function getPreguntas()
    {
        return $this->hasMany('App\Pregunta', 'idRequisito', 'id');
    }
}
