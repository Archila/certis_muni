<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Encargado;
use App\Models\Bitacora;
use App\Models\Folio;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;

class BitacoraController extends Controller
{   
    private $roles_gate = '{"roles":[ 1, 2 ]}';

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        
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
  
        $bitacoras = Bitacora::select('bitacora.*', 'persona.*', 'empresa.nombre as empresa', 'encargado.*');  
        $bitacoras->join('encargado', 'encargado_id', '=', 'encargado.id');
        $bitacoras->join('empresa', 'empresa_id', '=', 'empresa.id');
        $bitacoras->join('persona', 'encargado.persona_id', '=', 'persona.id');
         
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
        Gate::authorize('haveaccess', $this->roles_gate );

        $encargados = Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id');
        $encargados = $encargados->join('persona', 'persona_id', '=','persona.id')->get();

        $empresas = Empresa::all();

        return view('bitacoras.crear', ['encargados'=>$encargados, 'empresas'=>$empresas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
       
        /*$bitacora = Bitacora::where('codigo', '=',$request->codigo)->first();

        if ($carrera) {            
            return redirect()->route('carrera.crear')->with('error', 'ERROR');             
        }*/

        $bitacora = new Bitacora();
        $bitacora->semestre = $request->semestre;
        $bitacora->year = $request->year;
        $bitacora->tipo = $request->tipo;
        $bitacora->empresa_id = $request->empresa_id;
        $bitacora->encargado_id = $request->encargado_id;
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
        Gate::authorize('haveaccess', '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}' );

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
        Gate::authorize('haveaccess', $this->roles_gate );

        $bitacora = Bitacora::findOrFail($id);        

        return view('bitacoras.crear_folio',['bitacora'=>$bitacora]);
    }
}
