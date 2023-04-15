<?php

namespace App\Http\Controllers;

use App\Models\Folio;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use App\Models\Certi;
use App\Imports\CertiImport;

use Maatwebsite\Excel\Files\ExcelFile;

use Maatwebsite\Excel\Facades\Excel;

class CertiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function subir_archivo(Request $request)
    {
        
        Excel::import(new CertiImport, request()->file('file'));
        return redirect()->route('inicio.index'); 
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        $folio = Folio::where('numero', '=',$request->numero)->where('bitacora_id', $request->bitacora_id)->first();

        if ($folio) {            
            return redirect()->route('bitacora.crear_folio', $request->bitacora_id)->with(['error'=>'ERROR', 'descripcion'=>$request->descripcion]);             
        }              

        $folio = new Folio();
        $folio->numero = $request->numero;
        $folio->fecha_inicial = $request->fecha_inicial;
        $folio->fecha_final = $request->fecha_final;
        $folio->horas = $request->horas;
        $folio->descripcion = $request->descripcion;
        $folio->observaciones = $request->observaciones;
        $folio->bitacora_id = $request->bitacora_id;     
        $folio->save();

        $bitacora = Bitacora::findOrFail($request->bitacora_id);        
        $horas = Folio::where('bitacora_id',$bitacora->id)->sum('horas');
        $bitacora->horas = (string)$horas;
        $bitacora->save();
        
        return redirect()->route('bitacora.ver', $request->bitacora_id)->with('creado', $folio->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function show(Folio $folio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {   
        $folio = Folio::findOrFail($id);
        if($folio->revisado){ abort(403);}

        $bitacora = Bitacora::findOrFail($folio->bitacora_id);

        $folios = Folio::select('folio.*');
        $folios = $folios->where('bitacora_id',$bitacora->id);
        $folios = $folios->orderBy('numero')->get();

        return view('folios.editar', compact(['bitacora','folio', 'folios']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, $id)
    {
        $folio = Folio::findOrFail($id);

        $horas_anterior = $folio->horas;

        $folio->numero = $request->numero;
        $folio->fecha_inicial = $request->fecha_inicial;
        $folio->fecha_final = $request->fecha_final;
        $folio->horas = $request->horas;
        $folio->descripcion = $request->descripcion;
        $folio->observaciones = $request->observaciones;
        $folio->save();

        $bitacora = Bitacora::findOrFail($folio->bitacora_id);
        $horas = Folio::where('bitacora_id',$bitacora->id)->sum('horas');
        $bitacora->horas = $horas;
        $bitacora->save();
        
        return redirect()->route('bitacora.ver', $bitacora->id)->with('editado', $folio->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folio $folio)
    {
           
    }

    public function ver($id, Request $request)
    {

        $certi = Certi::select('certi.*');
        //$certi ->join('persona', 'persona_id', '=', 'persona.id');

        $certi = $certi->where('certi.id','=',$id);

        $certi = $certi->get()->first();

        return view('inicio.ver', compact(['certi']));

    }
}
