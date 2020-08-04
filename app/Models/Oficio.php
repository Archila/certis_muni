<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    protected $table = 'oficio';

    public function usuario(){
        return $this->belongsTo('App\Users');
    }

    public function bitacora(){
        return $this->hasOne('App\Models\Bitacora');
    }
}
