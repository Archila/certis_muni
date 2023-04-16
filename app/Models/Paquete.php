<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Paquete extends Model
{
    protected $table = 'paquete';

    protected $fillable = [
        'fecha', 'cantidad', 'observaciones', 'usuario_firma', 'usuario_realiza'
    ];
}
