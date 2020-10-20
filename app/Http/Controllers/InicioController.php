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

            /*$oficio = Auth::user()->oficios()->first();      
            $oficio = Oficio::where('usuario_id',Auth::user()->id)->orderBy('created_at', 'desc')->first();      
            if($oficio){ 
                $bitacoras = Bitacora::where('oficio_id',$oficio->id)->get(); 
                if($bitacoras->count() == 0){$bitacora = null;}
                else { $bitacora = $bitacoras->first();}
            }
            else{ $bitacora = null;}*/

            return redirect()->route('practica.index');            
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
            $rechazados = $oficios->where('aprobado', 1)->where('revisado',1)->where('rechazado',1)->count();
            $revisados = $oficios->where('aprobado', 1)->where('revisado',1)->where('rechazado',0)->count();

            $estudiantes = Oficio::select('oficio.tipo', 'persona.nombre', 'persona.apellido','estudiante.registro', 'bitacora.id as bitacora_id');
            $estudiantes->join('users', 'oficio.usuario_id', '=', 'users.id');
            $estudiantes->join('persona', 'users.persona_id', '=', 'persona.id');
            $estudiantes->join('estudiante', 'persona.id', '=', 'estudiante.persona_id');
            $estudiantes->join('bitacora', 'oficio.id', '=', 'bitacora.oficio_id');
            $estudiantes = $estudiantes->where('bitacora.valida',1);
            if(Auth::user()->rol->id != 1){                
                $estudiantes = $estudiantes->where('estudiante.usuario_supervisor',Auth::user()->id)->get();
            }
            else{
                $estudiantes = $estudiantes->get();
            }            

            $revisiones = Oficio::select('revision.horas', 'revision.fecha', 'bitacora.id as bitacora_id');
            $revisiones->join('users', 'oficio.usuario_id', '=', 'users.id');
            $revisiones->join('persona', 'users.persona_id', '=', 'persona.id');
            $revisiones->join('estudiante', 'persona.id', '=', 'estudiante.persona_id');
            $revisiones->join('bitacora', 'oficio.id', '=', 'bitacora.oficio_id');
            $revisiones->join('revision', 'bitacora.id', '=', 'revision.bitacora_id');
            $revisiones = $revisiones->where('bitacora.valida',1);
            if(Auth::user()->rol->id != 1){                
                $revisiones = $revisiones->where('estudiante.usuario_supervisor',Auth::user()->id)->get();
            }
            else{
                $revisiones = $revisiones->get();
            }     

            return view('inicio.index',compact(['aprobados', 'no_aprobados', 'no_revisados', 'rechazados', 'revisados','estudiantes','revisiones']));    
        }
    }
}
