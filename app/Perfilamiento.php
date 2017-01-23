<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfilamiento extends Model
{
    protected $table = 'perfilamientos';


    public function getNombrePerfil()
    {
        return $this->belongsTo('App\Perfiles', 'idPerfil', 'id');
    }
}
