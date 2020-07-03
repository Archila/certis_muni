<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';

    protected $fillable = [
        'nombre', 'descripcion',
    ];

    public function usuarios(){
        return $this->hasMany('App\User');
    }
}
