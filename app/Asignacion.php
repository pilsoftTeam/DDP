<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';


    public function getOficinasAsignadas()
    {
        return $this->hasOne('App\Oficinas', 'id', 'idOficinaAsignada')->with('getComuna');
    }

    public function getCreador()
    {
        return $this->hasOne('App\User', 'id', 'idUsuarioAsignador');
    }

    public function getRealizador()
    {
        return $this->hasOne('App\User', 'id', 'idUsuarioAsignado');
    }

    public function getCuestionarioRealizado()
    {
        return $this->hasMany('App\Resultados', 'idAsignacion', 'id');
    }
}
