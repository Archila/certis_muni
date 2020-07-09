<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Encargado;
use App\Models\Estudiante;
use App\Models\Empresa;
use App\Models\Bitacora;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    private $roles_gate = '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}';

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $id_bitacora = 1;
        $estudiante_id = 1;

        $bitacora = Bitacora::findOrFail($id_bitacora);
        
        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera');
        $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->where('estudiante.id',$estudiante_id)->first();

        $empresa = Empresa::findOrFail($bitacora->empresa_id);

        $encargado = Encargado::select('encargado.*', 'persona.*');
        $encargado->join('persona', 'persona_id', '=', 'person  a.id');
        $encargado = $encargado->where('encargado.id',$bitacora->encargado_id)->first();

        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/prueba', compact('empresa', 'estudiante', 'encargado', 'bitacora'));

        return $pdf->stream('archivo.pdf');
    }

    public function bitacora($id)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $bitacora = Bitacora::findOrFail($id);
        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $bitacora->usuario_id){abort(403);}
        }

        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id',$bitacora->usuario_id)->first();

        $empresa = Empresa::findOrFail($bitacora->empresa_id);

        $encargado = Encargado::select('encargado.*', 'persona.*', 'area.puesto as puesto');
        $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
        $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id');
        $encargado = $encargado->where('encargado.id',$bitacora->encargado_id)->first();

        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/caratula', compact('empresa', 'estudiante', 'encargado', 'bitacora'));

        return $pdf->stream('archivo.pdf');
    }

    public function oficio($id, Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
        $bitacora = Bitacora::findOrFail($id);
        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $bitacora->usuario_id){abort(403);}
        }
        
        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id', $bitacora->usuario_id)->first();
        
        $empresa = Empresa::findOrFail($bitacora->empresa_id);

        if($request->cbx_destinatario){

        }
        else{
            $encargado = Encargado::select('encargado.*', 'persona.*', 'area.puesto as puesto');
            $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
            $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
            $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id');
            $encargado = $encargado->where('encargado.id',$bitacora->encargado_id)->first();
            $destinatario = $encargado->nombre . ' ' . $encargado->apellido;
            $puesto = $encargado->puesto;
        }
        
        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/oficio', compact('empresa', 'estudiante', 'encargado', 'bitacora', 'destinatario', 'puesto'));

        return $pdf->stream('archivo.pdf');
    }
}
