<?php

namespace App\Http\Controllers;


use App\Models\Empresa;
use App\Models\Encargado;
use App\Models\Carrera;
use App\Models\Bitacora;
use App\Models\Oficio;
use App\Models\Certi;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Session;

class InicioController extends Controller
{
    private $roles_gate = '{"roles":[ 1, 2 ]}';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}' );

        $year = date('Y');
        $semestre = 1;
        if(date('M')>6){$semestre = 2;}
        if(empty(Session::get('year'))) {
            Session::put('year',$year);
        }
        if(empty(Session::get('semestre'))) {
            Session::put('semestre',$semestre);
        }
        $data = (object) [];
        $data->licencia = null;
        $data->expediente = null;
        $data->propietario = null;
        $data->inmueble = null;

        $pagina = 0;
        if($request->has('page')) $data->pagina = $request->page;
        else $data->pagina = 1;
        $tabla =[];

        switch(Auth::user()->rol->id){
            Case 1:     $tabla = Certi::paginate(15); 
                        return view('inicio.administrador',compact(['data','tabla']));    
                        break; 
            
            Case 2:     
                        $tabla = Certi::select('*');
                        if ($request->has('licencia') && trim($request->licencia)!= '') {
                            $tabla->where('no_licencia', 'like', '%' . $request->licencia . '%');
                            $data->licencia = $request->licencia;
                        }
                        if ($request->has('expediente') && trim($request->expediente)!= '') {
                            $tabla->where('no_expediente', 'like', '%' . $request->expediente . '%');
                            $data->expediente = $request->expediente;
                        }
                        if ($request->has('propietario') && trim($request->propietario)!= '') {
                            $tabla->where('nombre_propietario', 'like', '%' . $request->propietario . '%');
                            $data->propietario = $request->propietario;
                        }
                        if ($request->has('inmueble') && trim($request->inmueble)!= '') {
                            $tabla->where('direccion_inmueble', 'like', '%' . $request->inmueble . '%');
                            $data->inmueble = $request->inmueble;
                        }
                        $tabla = $tabla->paginate(15);
                        return view('inicio.operador',compact(['data','tabla']));    
                        break; 
            
            Case 3:     $tabla = Certi::select('*');
                        if ($request->has('licencia') && trim($request->licencia)!= '') {
                            $tabla->where('no_licencia', 'like', '%' . $request->licencia . '%');
                            $data->licencia = $request->licencia;
                        }
                        if ($request->has('expediente') && trim($request->expediente)!= '') {
                            $tabla->where('no_expediente', 'like', '%' . $request->expediente . '%');
                            $data->expediente = $request->expediente;
                        }
                        if ($request->has('propietario') && trim($request->propietario)!= '') {
                            $tabla->where('nombre_propietario', 'like', '%' . $request->propietario . '%');
                            $data->propietario = $request->propietario;
                        }
                        if ($request->has('inmueble') && trim($request->inmueble)!= '') {
                            $tabla->where('direccion_inmueble', 'like', '%' . $request->inmueble . '%');
                            $data->inmueble = $request->inmueble;
                        }
                        $tabla = $tabla->paginate(10);
                        return view('inicio.cliente',compact(['data','tabla']));    
                        break; 

            Case 4:  return view('inicio.informatica',compact(['data','tabla']));    
                        break; 

            default:  return view('inicio.cliente',compact(['data','tabla']));    
            break;             
        }
    }
}
