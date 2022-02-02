<?php

namespace App\Http\Controllers;


use App\Models\Empresa;
use App\Models\Encargado;
use App\Models\Carrera;
use App\Models\Bitacora;
use App\Models\Oficio;
use App\Models\Folio;
use App\Models\Estudiante;
use App\Models\Solicitud;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Session;

class PracticaController extends Controller
{
    private $roles_gate = '{"roles":[ 1, 2 ]}';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}' );

        if(Auth::user()->rol->id == 2){ 

            $oficio = Auth::user()->oficios()->first();      
            $oficio = Oficio::where('usuario_id',Auth::user()->id)->orderBy('created_at', 'desc')->first();      
            if($oficio){ 
                $bitacora = Oficio::find($oficio->id)->bitacora()->first(); 
                if(!$bitacora){$bitacora = null;}
            }
            else{ $bitacora = null;}
            $encargado = null;
            $empresa = null;
            $folios = null;
            if($bitacora){
                $empresa = Empresa::findOrFail($oficio->empresa_id);
                $folios = Folio::where('bitacora_id', $bitacora->id)->orderBy('numero', 'asc')->get();

                $encargado= Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id', 'area_encargado.puesto as puesto');
                $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
                $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
                $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id');
                $encargado = $encargado->where('encargado.id', $bitacora->encargado_id)->first();
            }

            $solicitud = Solicitud::all();
            $solicitud = $solicitud->where('usuario_id',Auth::user()->id)->first();
            
            return view('practicas.individual',compact(['solicitud','bitacora', 'oficio', 'empresa','encargado', 'folios']));            
        }
        else{

            if($request->has('year')) {
                $year=$request->year;
                Session::put('year', $year);
            } else {
                $year = Session::get('year');
            }
            if($request->has('semestre')) {
                $semestre=$request->semestre;
                Session::put('semestre', $semestre);
            } else {
                $semestre = Session::get('semestre');
            }        
            
            $oficios = Oficio::select('oficio.*','persona.nombre', 'persona.apellido','persona.correo', 'estudiante.registro');
            $oficios ->join('users', 'oficio.usuario_id', '=', 'users.id');
            $oficios ->join('persona', 'users.persona_id', '=', 'persona.id');
            $oficios ->join('estudiante', 'persona.id', '=', 'estudiante.persona_id');
            if(Auth::user()->rol->id != 1){
                $oficios = $oficios->where('estudiante.usuario_supervisor',Auth::user()->id);
            }
            $oficios = $oficios->where('estudiante.year',$year);
            $oficios = $oficios->where('estudiante.semestre',$semestre);
            $oficios = $oficios->orderBy('estudiante.registro', 'asc')->get();

            $bitacoras = Bitacora::select('bitacora.codigo','persona.nombre', 'persona.apellido','persona.correo', 'estudiante.registro',
                'bitacora.id as bitacora_id', 'oficio.id as oficio_id', 'oficio.tipo');
            $bitacoras ->join('oficio', 'bitacora.oficio_id', '=', 'oficio.id');
            $bitacoras ->join('users', 'oficio.usuario_id', '=', 'users.id');
            $bitacoras ->join('persona', 'users.persona_id', '=', 'persona.id');
            $bitacoras ->join('estudiante', 'persona.id', '=', 'estudiante.persona_id');
            if(Auth::user()->rol->id != 1){
                $bitacoras = $bitacoras->where('estudiante.usuario_supervisor',Auth::user()->id);
            }
            $bitacoras = $bitacoras->where('estudiante.year',$year);
            $bitacoras = $bitacoras->where('estudiante.semestre',$semestre);
            $bitacoras = $bitacoras->orderBy('estudiante.registro', 'asc')->get();


            $solicitudes = Solicitud::select('solicitud.*','persona.nombre', 'persona.apellido','persona.correo', 'estudiante.registro');
            $solicitudes ->join('users', 'solicitud.usuario_id', '=', 'users.id');
            $solicitudes ->join('persona', 'users.persona_id', '=', 'persona.id');
            $solicitudes ->join('estudiante', 'persona.id', '=', 'estudiante.persona_id');
            if(Auth::user()->rol->id != 1){
                $solicitudes = $solicitudes->where('estudiante.usuario_supervisor',Auth::user()->id);
            }
            $solicitudes = $solicitudes->where('estudiante.year',$year);
            $solicitudes = $solicitudes->where('estudiante.semestre',$semestre);
            $solicitudes = $solicitudes->orderBy('estudiante.registro', 'asc')->get();

            //return dd($solicitudes);
            if($bitacoras->count()== 0){$bitacoras = null;}
            if($oficios->count()== 0){$oficios = null;}
            if($solicitudes->count()== 0){$solicitudes = null;}

            return view('practicas.index',compact(['solicitudes','bitacoras','oficios','year', 'semestre']));    
        }
    }

    public function solicitud()
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 2 ]}' );

        $empresas = Empresa::where('publico',1)->get();    
        $empresa = Empresa::where('usuario_id', Auth::user()->id )->first();

        return view('practicas.solicitud',compact(['empresas', 'empresa']));    
    }

    public function respuesta(Request $request)
    {
        
        $request->validate([
            'file' => 'required|mimes:pdf,PDF|max:2048',
        ]);

        $path = Storage::put('public', $request->file);        
        
        $oficio = Oficio::findOrFail($request->oficio_id);
        $oficio->ruta_pdf = $path;
        $oficio->save();

        if(Auth::user()->rol->id == 2){
            return redirect()->route('practica.index');
        }
        else{
            return redirect()->route('oficio.revisar', $oficio->id);
        }
        
    }
}
