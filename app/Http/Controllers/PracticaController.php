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

            $year = date('Y');
            $semestre = 1;
            if(date('M')>6){$semestre = 2;}
            if($request->has('year')) {$year=$request->year;}
            if($request->has('semestre')) {$semestre=$request->semestre;}

            $estudiantes = Estudiante::select('estudiante.*', 'carrera.nombre as carrera', 'persona.*', 'estudiante.id as estudiante_id',
            'users.id as usuario_id');
            $estudiantes ->join('carrera', 'carrera_id', '=', 'carrera.id');
            $estudiantes ->join('persona', 'persona_id', '=', 'persona.id');
            $estudiantes ->join('users', 'persona.id', '=', 'users.persona_id');
            if(Auth::user()->rol->id != 1){
                $estudiantes = $estudiantes->where('usuario_supervisor',Auth::user()->id);
            }
            $estudiantes = $estudiantes->where('estudiante.year',$year);
            $estudiantes = $estudiantes->where('estudiante.semestre',$semestre);
            $estudiantes = $estudiantes->orderBy('estudiante.created_at', 'asc')->get();

            $bitacoras = Bitacora::all();
            $oficios = Oficio::orderBy('updated_at','desc')->get();
            $solicitudes = Solicitud::all();
            if($bitacoras->count()== 0){$bitacoras = null;}
            if($oficios->count()== 0){$oficios = null;}
            if($solicitudes->count()== 0){$solicitudes = null;}

            return view('practicas.index',compact(['solicitudes','bitacoras','oficios', 'estudiantes', 'year', 'semestre']));    
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
