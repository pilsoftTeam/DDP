<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oficinas extends Model
{
    protected $table = 'oficinas';


    public function getAsignaciones()
    {
        return $this->hasMany('App\Asignacion', 'idOficinaAsignada', 'id');
    }
}
