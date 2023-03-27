<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permiso';

    protected $fillable = [
        'nombre', 'accion', 'tabla','rol_id'
    ];

    public function rol(){
        return $this->belongsTo('App\Rol');
    }
}
