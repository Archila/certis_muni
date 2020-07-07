<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';

    public function usuario(){
        return $this->belongsTo('App\User');
    }

    public function estudiante(){
        return $this->hasOne('App\Models\Estudiante');
    }

    public function supervisor(){
        return $this->hasOne('App\Models\Supervisor');
    }
}
