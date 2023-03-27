<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    private $roles_gate = '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cambiar()
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        return view('usuarios.cambiar_clave');
    }

    public function confirmar(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $clave=bcrypt($request->clave);
        
        $usuario = User::where('id','=',Auth::user()->id)->first();
        //$usuario->password = bcrypt('test');
        //$usuario->save();
        if($usuario){
            if(Hash::check($request->clave,$usuario->password)) {
                return redirect()->route('usuario.nueva')->with('validado' , 1); 
            } else {
                return redirect()->route('usuario.cambiar')->with('error', 'ERROR'); 
            }
        }
        else{
            return redirect()->route('usuario.cambiar')->with('error', 'ERROR'); 
        }
       
    }


    public function nueva(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        return view('usuarios.nueva');
    }

    public function actualizar(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        if($request->clave1 == $request->clave2){
            $usuario = User::where('id','=',Auth::user()->id)->first();
            $clave=bcrypt($request->clave);
            $usuario->password = $clave;
            $usuario->save();
            return view('usuarios.exito');
        }
        else{
            return redirect()->route('usuario.nueva')->with('error', 'ERROR'); 
        }
    }
}
