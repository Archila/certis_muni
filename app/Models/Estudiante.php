<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiante';

    public function persona(){
        return $this->hasOne('App\Models\Persona');
    }
}
