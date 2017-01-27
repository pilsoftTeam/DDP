<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regiones extends Model
{
    protected $table = 'regiones';


    public function getComunas()
    {
        return $this->hasMany('App\Comunas', 'idRegion', 'id')->with('getOficinas');
    }
}
