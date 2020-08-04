<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carrera';

    public function estudiantes(){
        return $this->hasMany('App\Models\Estudiante');
    }
}
