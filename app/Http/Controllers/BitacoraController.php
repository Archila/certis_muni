<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Encargado;
use App\Models\Bitacora;
use App\Models\Folio;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

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
  
        $bitacoras = Bitacora::select('bitacora.*', 'persona.*', 'empresa.nombre as empresa', 'encargado.*', 'bitacora.id as bitacora_id');  
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

        $btn_nuevo = true;
        if(Auth::user()->rol->id == 2){   
            $bitacoras= $bitacoras->Where('usuario_id', Auth::user()->id);

            $bitacora_est = Bitacora::where('usuario_id', Auth::user()->id)->first();
            if($bitacora_est){$btn_nuevo=false;}
        }


        return view('bitacoras.index',compact(['bitacoras','btn_nuevo']));
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
        $encargados = $encargados->join('persona', 'persona_id', '=','persona.id');
        
        if(Auth::user()->rol->id == 2){   
            $bitacora_est = Bitacora::where('usuario_id',Auth::user()->id)->first();
            if($bitacora_est){abort(403);}
            $empresas = Empresa::where('publico',1)->get();
            $encargados = $encargados->where('usuario_id',Auth::user()->id)->get();
        }
        else{
            $empresas = Empresa::all();
            $encargados = $encargados->get();
        }
        

        $empresa = Empresa::where('usuario_id', Auth::user()->id)->first();

        $encargado= Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id', 'area.puesto as puesto');
        $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
        $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id')->get();
        $encargado = $encargado->where('usuario_id', Auth::user()->id)->first();

        return view('bitacoras.crear', ['encargados'=>$encargados, 'empresas'=>$empresas, 'empresa'=>$empresa, 'encargado'=>$encargado]);
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
        if($request->encargado_id){$encargado_id = $request->encargado_id;}
        else { $encargado = Encargado::where('usuario_id',Auth::user()->id)->first();
            $encargado_id = $encargado->id;}

        if($request->empresa_id){$empresa_id = $request->empresa_id;}
        else { $empresa = Empresa::where('usuario_id',Auth::user()->id)->first();
            $empresa_id = $empresa->id;}        

        $bitacora = new Bitacora();
        $bitacora->semestre = $request->semestre;
        $bitacora->year = $request->year;
        $bitacora->tipo = $request->tipo;
        $bitacora->empresa_id = $empresa_id;
        $bitacora->encargado_id = $encargado_id;
        $bitacora->usuario_id = Auth::user()->id;
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

        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $bitacora->usuario_id){abort(403);}
        }

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
