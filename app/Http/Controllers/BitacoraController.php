<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Folio;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'all' => 'nullable|boolean',
            'many' => 'nullable|integer',
            'sort_by' => 'nullable|string',
            'direction' => 'nullable|string',
            'semestre' => 'nullable|string',
            'year' => 'nullable|string',
        ]);
  
        $many = 5;
        if($request->has('many')) $many = $request->many;
  
        $sort_by = 'bitacora.created_at';
        if($request->has('sort_by')) $sort_by = 'bitacora.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $bitacoras = Bitacora::orderBy($sort_by, $direction);  
         
        if ($request->has('year')) {
          $bitacoras->orWhere('year', '=', $request->codigo);
        }
  
        if ($request->has('many')) {
          $bitacoras = $bitacoras->orderBy($sort_by, $direction)->paginate($many);          
        }
        else {
          $bitacoras = $bitacoras->orderBy($sort_by, $direction)->get();
        }


        return view('bitacoras.index',compact('bitacoras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('bitacoras.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'semestre' => 'required|string',
            'year' => 'required|string',
        ]);

        /*$bitacora = Bitacora::where('codigo', '=',$request->codigo)->first();

        if ($carrera) {            
            return redirect()->route('carrera.crear')->with('error', 'ERROR');             
        }*/

        $bitacora = new Bitacora();
        $bitacora->semestre = $request->semestre;
        $bitacora->year = $request->year;
        $bitacora->usuario_id = 1;
        $bitacora->save();

        return redirect()->route('bitacora.index')->with('creado', $bitacora->id);     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {
        $bitacora = Bitacora::findOrFail($id);

        $folios = Folio::select('folio.*');
        $folios = $folios->where('bitacora_id',$bitacora->id);
        $folios = $folios->orderBy('numero')->get();

        return view('bitacoras.ver',['bitacora'=>$bitacora, 'folios'=>$folios]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Bitacora $bitacora)
    {
        //
    }

    public function crear_folio($id)
    {
        $bitacora = Bitacora::findOrFail($id);        

        return view('bitacoras.crear_folio',['bitacora'=>$bitacora]);
    }
}
