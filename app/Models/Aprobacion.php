<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Aprobacion extends Model
{
    protected $table = 'aprobacion';

    protected $fillable = [
        'fecha', 'observaciones', 'id_usuario', 'id_certi'
    ];
}
