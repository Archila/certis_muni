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

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class PracticaController extends Controller
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

            $estudiantes = Estudiante::select('estudiante.*', 'carrera.nombre as carrera', 'persona.*', 'estudiante.id as estudiante_id',
            'users.id as usuario_id');
            $estudiantes ->join('carrera', 'carrera_id', '=', 'carrera.id');
            $estudiantes ->join('persona', 'persona_id', '=', 'persona.id');
            $estudiantes ->join('users', 'persona.id', '=', 'users.persona_id');
            if(Auth::user()->rol->id != 1){
                $estudiantes = $estudiantes->where('usuario_supervisor',Auth::user()->id);
            }
            $estudiantes = $estudiantes->orderBy('estudiante.created_at', 'asc')->get();

            $bitacoras = Bitacora::get();
            $oficios = Oficio::orderBy('updated_at','desc')->get();
            if($bitacoras->count()== 0){$bitacoras = null;}
            if($oficios->count()== 0){$oficios = null;}

            return view('practicas.index',compact(['bitacoras','oficios', 'estudiantes']));    
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

        return redirect()->route('practica.index');
    }

}
