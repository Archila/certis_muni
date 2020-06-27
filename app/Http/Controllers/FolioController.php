<?php

namespace App\Http\Controllers;

use App\Models\Folio;
use App\Models\Bitacora;
use Illuminate\Http\Request;

class FolioController extends Controller
{
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
        $folio->bitacora_id = $request->bitacora_id;     
        $folio->save();

        $bitacora = Bitacora::findOrFail($request->bitacora_id);
        $horas =  (float)$bitacora->horas + (float)$request->horas;
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
    public function edit(Folio $folio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folio $folio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folio $folio)
    {
        //
    }
}
