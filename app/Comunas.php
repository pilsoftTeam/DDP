<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunas extends Model
{
    protected $table = 'comunas';

    public function getOficinas()
    {
        return $this->hasMany('App\Oficinas', 'idComuna', 'id')->with('getAsignaciones');
    }

    public function getRegion()
    {
        return $this->belongsTo('App\Regiones', 'idRegion', 'id');
    }
}
