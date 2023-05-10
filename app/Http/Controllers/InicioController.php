<?php

namespace App\Http\Controllers;


use App\Models\Empresa;
use App\Models\Encargado;
use App\Models\Carrera;
use App\Models\Bitacora;
use App\Models\Oficio;
use App\Models\Certi;
use App\Models\Paquete;
use App\Models\Rol;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Session;

use DB;

class InicioController extends Controller
{
    private $roles_gate = '{"roles":[ 1, 2 ]}';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = (object) [];
        $data->fecha_inicio = null;
        $data->fecha_fin = null;
        $data->licencia = null;
        $data->expediente = null;
        $data->propietario = null;
        $data->numero = null;
        $data->inmueble = null;

        $user = Auth::user();
        $rol = Auth::user()->rol;

        $pagina = 0;
        if($request->has('page')) $data->pagina = $request->page;
        else $data->pagina = 1;
        $tabla =[];

        if(Auth::user()->rol->id == 4){
            $usuarios = User::select('users.id', 'users.name', 'users.username', 'rol.nombre as rol', 'users.activo', 'users.created_at');
            $usuarios = $usuarios->join('rol', 'rol.id', 'users.rol_id');
            $usuarios = $usuarios->get();
            $roles = Rol::all();
            return view('inicio.informatica',compact(['usuarios', 'roles']));    
        }    
        $tabla = Certi::select('paquete.fecha', 'paquete.observaciones', 'paquete.id', DB::raw("COUNT(*) as cantidad")); 
        $tabla = $tabla->join('paquete', 'certi.id_paquete', '=', 'paquete.id');
        $tabla->groupBy('paquete.fecha', 'paquete.observaciones', 'paquete.id');
        
        if(Auth::user()->rol->id == 3){            
            $tabla->where("certi.estado", "=", 1); 
        } 

        if ($request->has('licencia') && trim($request->licencia)!= '') {
            $tabla->where('certi.no_licencia', 'like', '%' . $request->licencia . '%');
            $data->licencia = $request->licencia;
        }
        if ($request->has('expediente') && trim($request->expediente)!= '') {
            $tabla->where('certi.no_expediente', 'like', '%' . $request->expediente . '%');
            $data->expediente = $request->expediente;
        }
        if ($request->has('propietario') && trim($request->propietario)!= '') {
            $tabla->where('certi.nombre_propietario', 'like', '%' . $request->propietario . '%');
            $data->propietario = $request->propietario;
        }
        if ($request->has('numero') && trim($request->numero)!= '') {
            $tabla->where('certi.numero', 'like', '%' . $request->numero . '%');
            $data->numero = $request->numero;
        }
        if ($request->has('inmueble') && trim($request->inmueble)!= '') {
            $tabla->where('certi.codigo_inmueble', 'like', '%' . $request->inmueble . '%');
            $data->inmueble = $request->inmueble;
        }
        
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin') ) {
            
            $tabla->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            $tabla = $tabla->orderBy('paquete.created_at', 'DESC')->paginate(15);
            $data->fecha_inicio = $request->fecha_inicio;
            $data->fecha_fin = $request->fecha_fin;
        } else if($request->filled('fecha_inicio')) {
            $tabla->where('paquete.fecha','>=',$request->fecha_inicio);
            $data->fecha_inicio = $request->fecha_inicio;
            $tabla = $tabla->orderBy('paquete.created_at', 'DESC')->paginate(15);
        } else if($request->filled('fecha_fin')) {
            $tabla->where('paquete.fecha','<=',$request->fecha_fin);
            $data->fecha_fin = $request->fecha_fin;
            $tabla = $tabla->orderBy('paquete.created_at', 'DESC')->paginate(15);
        }  else {
            $tabla = $tabla->orderBy('paquete.created_at', 'DESC')->paginate(15);
        }       

        $error = '';
        if($request->filled('error')){
            $error = $request->error;
        }

        return view('inicio.paquete',compact(['data','tabla', 'user', 'rol', 'error']));   
        
    }
}
