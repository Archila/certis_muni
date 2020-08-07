<?php

namespace App\Http\Controllers;


use App\Models\Empresa;
use App\Models\Encargado;
use App\Models\Carrera;
use App\Models\Bitacora;
use App\Models\Oficio;
use App\Models\Estudiante;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

class InicioController extends Controller
{
    private $roles_gate = '{"roles":[ 1, 2 ]}';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}' );

        if(Auth::user()->rol->id == 2){ 

            $oficio = Auth::user()->oficios()->first();      
            $oficio = Oficio::where('usuario_id',Auth::user()->id)->orderBy('created_at', 'desc')->first();      
            if($oficio){ 
                $bitacora = Oficio::find($oficio->id)->bitacora(); 
                if($bitacora->count() == 0){$bitacora = null;}
            }
            else{ $bitacora = null;}
            
            return view('practicas.individual',compact(['bitacora', 'oficio']));            
        }
        else{

            $oficios = Oficio::select('oficio.*', 'estudiante.usuario_supervisor as usuario_supervisor');
            $oficios->join('users', 'oficio.usuario_id', '=', 'users.id');
            $oficios->join('persona', 'users.persona_id', '=', 'persona.id');
            $oficios->join('estudiante', 'persona.id', '=', 'estudiante.persona_id');

            if(Auth::user()->rol->id != 1){                
                $oficios = $oficios->where('estudiante.usuario_supervisor',Auth::user()->id)->get();
            }
            else{
                $oficios = $oficios->get();
            }

            $aprobados = $oficios->where('aprobado', 1)->count();
            $no_aprobados=$oficios->where('aprobado', 0)->count();

            $no_revisados = $oficios->where('aprobado', 1)->where('revisado',0)->count();
            $rechazados = $oficios->where('aprobado', 1)->where('revisado',1)->where('rechazado',1)->count();;
            $revisados = $oficios->where('aprobado', 1)->where('revisado',1)->where('rechazado',0)->count();;

            return view('inicio.index',compact(['aprobados', 'no_aprobados', 'no_revisados', 'rechazados', 'revisados']));    
        }
    }
}
