<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Encargado;
use App\Models\Estudiante;
use App\Models\Supervisor;
use App\Models\Empresa;
use App\Models\Bitacora;
use App\Models\Oficio;
use App\Models\Folio;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

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

    public function caratula($id)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $bitacora = Bitacora::findOrFail($id);
        $oficio = Oficio::findOrFail($bitacora->oficio_id);
        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $oficio->usuario_id){abort(403);}
        }

        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera', 'carrera.id as carrera_id');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id',$oficio->usuario_id)->first();

        $carrera_id = $estudiante->carrera_id;
        if($carrera_id == 1){$carrera = 'Civil';}
        elseif($carrera_id == 2){$carrera = 'Mecánica';}
        elseif($carrera_id == 3){$carrera = 'Industrial';}
        elseif($carrera_id == 4){$carrera = 'Mecánica Industrial';}
        elseif($carrera_id == 5 ){$carrera = 'en Sistemas';}

        $empresa = Empresa::findOrFail($oficio->empresa_id);

        $encargado = Encargado::select('encargado.*', 'persona.*', 'area_encargado.puesto as puesto');
        $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
        $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id');
        $encargado = $encargado->where('encargado.id',$bitacora->encargado_id)->first();

        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/caratula', compact('empresa', 'estudiante', 'encargado', 'bitacora', 'oficio','carrera'));

        return $pdf->stream('archivo.pdf');
    }

    public function oficio($id, Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
        $bitacora = Bitacora::findOrFail($id);
        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $bitacora->usuario_id){abort(403);}
        }
        
        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera', 'carrera.id as carrera_id');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id', $bitacora->usuario_id)->first();
        
        $empresa = Empresa::findOrFail($bitacora->empresa_id);

        if($request->destinatario){
            $destinatario = $request->destinatario;
            $puesto = $request->puesto;
        }
        else{
            $encargado = Encargado::select('encargado.*', 'persona.*', 'area_encargado.puesto as puesto');
            $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
            $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
            $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id');
            $encargado = $encargado->where('encargado.id',$bitacora->encargado_id)->first();
            $destinatario = $encargado->nombre . ' ' . $encargado->apellido;
            $puesto = $encargado->puesto;
        }

        //Rol en funcion de la carrera del estudiante.
        $supervisor = Supervisor::select('supervisor.*', 'persona.*');
        $supervisor = $supervisor->join('persona', 'persona_id', '=', 'persona.id');
        $supervisor = $supervisor->join('users', 'persona.id', '=', 'users.persona_id');
        $supervisor = $supervisor->where('users.id', '=', $estudiante->usuario_supervisor)->first();
        
        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/oficio', compact('empresa', 'estudiante', 'bitacora', 'destinatario', 'puesto', 'supervisor'));

        return $pdf->stream('archivo.pdf');
    }

    public function folios($id, Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
        $bitacora = Bitacora::findOrFail($id);
        $oficio = Oficio::findOrFail($bitacora->oficio_id);
        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $oficio->usuario_id){abort(403);}
        }

        $folios = Folio::where('bitacora_id',$bitacora->id)->get();
                
        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/folios', compact('bitacora', 'folios'));

        return $pdf->stream('archivo.pdf');
    }

    public function prueba($id, Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
        $bitacora = Bitacora::findOrFail($id);
        $oficio = Oficio::findOrFail($bitacora->oficio_id);
        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $oficio->usuario_id){abort(403);}
        }

        $folios = Folio::where('bitacora_id',$bitacora->id)->get();
       
        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        return view('pdf/folios', compact('bitacora', 'folios'));

        //return $pdf->stream('archivo.pdf');
    }

    public function vacios($id, Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
        $bitacora = Bitacora::findOrFail($id);
        $oficio = Oficio::findOrFail($bitacora->oficio_id);
        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $oficio->usuario_id){abort(403);}
        }
        
        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/vacios', compact('bitacora'));

        return $pdf->stream('archivo.pdf');
    }

    public function individual($id, Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
        $folio = Folio::findOrFail($id);

        $bitacora = Bitacora::findOrFail($folio->bitacora_id);
        $oficio = Oficio::findOrFail($bitacora->oficio_id);
        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $oficio->usuario_id){abort(403);}
        }

        $folios = Folio::where('bitacora_id',$bitacora->id)->get();
                
        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/individual', compact('folio', 'folios'));

        return $pdf->stream('individual.pdf');
    }

    public function aplicada()
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
        $ruta = "public/static/plantilla_aplicada.pdf";
        // file not found
        if(!Storage::exists($ruta) ) {
            abort(404);
        }
    
        $pdfContent = Storage::get($ruta);

        // for pdf, it will be 'application/pdf'
        $type       = Storage::mimeType($ruta);
    
        return Response::make($pdfContent, 200, [
            'Content-Type'        => $type,
            'Content-Disposition' => 'inline; filename="plantilla_aplicada"'
        ]);
    }

    public function docente()
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
        $ruta = "public/static/plantilla_docencia.pdf";
        // file not found
        if(!Storage::exists($ruta) ) {
            abort(404);
        }
    
        $pdfContent = Storage::get($ruta);

        // for pdf, it will be 'application/pdf'
        $type       = Storage::mimeType($ruta);
    
        return Response::make($pdfContent, 200, [
            'Content-Type'        => $type,
            'Content-Disposition' => 'inline; filename="plantilla_docencia"'
        ]);
    }

    public function investigacion()
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
        $ruta = "public/static/plantilla_investigacion.pdf";
        // file not found
        if(!Storage::exists($ruta) ) {
            abort(404);
        }
    
        $pdfContent = Storage::get($ruta);

        // for pdf, it will be 'application/pdf'
        $type       = Storage::mimeType($ruta);
    
        return Response::make($pdfContent, 200, [
            'Content-Type'        => $type,
            'Content-Disposition' => 'inline; filename="plantilla_investigacion"'
        ]);
    }

    public function ver_archivo(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
        $ruta = $request->ruta;
        // file not found
        if(!Storage::exists($ruta) ) {
            abort(404);
        }
    
        $pdfContent = Storage::get($ruta);

        // for pdf, it will be 'application/pdf'
        $type       = Storage::mimeType($ruta);
    
        return Response::make($pdfContent, 200, [
            'Content-Type'        => $type,
            'Content-Disposition' => 'inline; filename="documento_practicas"'
        ]);
    }

}
