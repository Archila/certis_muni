<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Encargado;
use App\Models\Estudiante;
use App\Models\Empresa;
use App\Models\Bitacora;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function index()
    {
        $id_bitacora = 1;
        $estudiante_id = 1;

        $bitacora = Bitacora::findOrFail($id_bitacora);
        
        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera');
        $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->where('estudiante.id',$estudiante_id)->first();

        $empresa = Empresa::findOrFail($bitacora->empresa_id);

        $encargado = Encargado::select('encargado.*', 'persona.*');
        $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->where('encargado.id',$bitacora->encargado_id)->first();

        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/prueba', compact('empresa', 'estudiante', 'encargado', 'bitacora'));

        return $pdf->stream('archivo.pdf');
    }

    public function caratula()
    {
        $id_bitacora = 1;
        $estudiante_id = 1;

        $bitacora = Bitacora::findOrFail($id_bitacora);
        
        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera');
        $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->where('estudiante.id',$estudiante_id)->first();

        $empresa = Empresa::findOrFail($bitacora->empresa_id);

        $encargado = Encargado::select('encargado.*', 'persona.*');
        $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->where('encargado.id',$bitacora->encargado_id)->first();

        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/prueba', compact('empresa', 'estudiante', 'encargado', 'bitacora'));

        return $pdf->stream('archivo.pdf');
    }

    public function oficio()
    {
        $id_bitacora = 1;
        $estudiante_id = 1;

        $bitacora = Bitacora::findOrFail($id_bitacora);
        
        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera');
        $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->where('estudiante.id',$estudiante_id)->first();

        $empresa = Empresa::findOrFail($bitacora->empresa_id);

        $encargado = Encargado::select('encargado.*', 'persona.*');
        $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->where('encargado.id',$bitacora->encargado_id)->first();

        //$pdf = \PDF::loadView('pdf/prueba',['estudiante'->$estudiante, 'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora]);
        $pdf = \PDF::loadView('pdf/oficio', compact('empresa', 'estudiante', 'encargado', 'bitacora'));

        return $pdf->stream('archivo.pdf');
    }
}
