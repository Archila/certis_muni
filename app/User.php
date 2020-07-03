<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'carne',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol(){
        return $this->belongsTo('App\Models\Rol');
    }

    public function mostrarTabla($tabla){
        
        if($this->rol->id == 1) {return true;}

        if($this->rol->id == 2){
            if($tabla == 'bitacora'){ return true;}
            if($tabla == 'estudiante'){ return false;}
            if($tabla == 'empresa'){ return true;}
            if($tabla == 'encargado'){ return false;}
            if($tabla == 'notificacion'){ return true;}
            if($tabla == 'carrera'){ return false;}
            if($tabla == 'supervisor'){ return false;}
            if($tabla == 'rol'){ return false;}
        }

        if($this->rol->id >= 3){
            if($tabla == 'bitacora'){ return false;}
            if($tabla == 'estudiante'){ return true;}
            if($tabla == 'empresa'){ return true;}
            if($tabla == 'encargado'){ return false;}
            if($tabla == 'notificacion'){ return true;}
            if($tabla == 'carrera'){ return false;}
            if($tabla == 'supervisor'){ return false;}
            if($tabla == 'rol'){ return false;}
        }       

        return false;
    }
}
