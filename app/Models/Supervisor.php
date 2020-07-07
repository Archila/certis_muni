<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $table = 'supervisor';

    public function persona(){
        return $this->hasOne('App\Models\Persona');
    }
}
