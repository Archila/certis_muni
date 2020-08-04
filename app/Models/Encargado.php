<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
    protected $table = 'encargado';

    public function bitacoras(){
        return $this->hasMany('App\Models\Bitacora');
    }
}
