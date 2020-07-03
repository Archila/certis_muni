<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('haveaccess', function (User $user, $array)
        {   
            $json=json_decode($array,true);
            //$test = $roles_array;
            //dd($user->rol->nombre);  
            if($user->rol->id==1){ return true;}
            foreach ($json['roles'] as $rol)   
            {
                if($rol == $user->rol->id){
                    return true;
                } 
            }                      
            return false;
        });
        //
    }
}
