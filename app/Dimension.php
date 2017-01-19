<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    protected $table = 'dimensiones';


    public function getRequisitos()
    {
        return $this->hasMany('App\Requisito', 'idDimension', 'id');
    }
}
