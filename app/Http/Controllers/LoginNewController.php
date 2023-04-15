<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
 
class LoginNewController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $usuario =  Auth::user();
            $usuario->rol =  Auth::user()->rol;
            return response()->json(['success'=>true, 'usuario'=>$usuario]);
        }
        return response()->json(['success'=>false, 'message'=>'Error al buscar usuario y clave']);
    }

    /**
     * Handle an logout attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['success'=>true, 'message'=>'Sesión finalizada.']);
    }
}