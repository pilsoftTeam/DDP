<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oficinas extends Model
{
    protected $table = 'oficinas';


    public function getAsignaciones()
    {
        return $this->hasMany('App\Asignacion', 'idOficinaAsignada', 'id')->where('estado', '!=' ,'rechazado')->with('getCreador', 'getRealizador');
    }

    public function getComuna(){
        return $this->belongsTo('App\Comunas', 'idComuna', 'id')->with('getRegion');
    }
}
