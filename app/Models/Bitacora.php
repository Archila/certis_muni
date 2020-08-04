<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacora';

    public function oficio(){
        return $this->belongsTo('App\Models\Oficio');
    }

    public function encargado(){
        return $this->belongsTo('App\Models\Encargado');
    }
}
