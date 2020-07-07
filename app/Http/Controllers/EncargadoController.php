<?php

namespace App\Http\Controllers;

use App\Models\Encargado;
use App\Models\Area;
use App\Models\Persona;
use App\Models\AreaEncargado;
use App\Models\Empresa;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

class EncargadoController extends Controller
{
    private $roles_gate = '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}';

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
            'nombre' => 'nullable|string',
            'apellido' => 'nullable|string',
            'colegiado' => 'nullable|string',
        ]);

        $many = 5;
        if($request->has('many')) $many = $request->many;
  
        $sort_by = 'encargado.created_at';
        if($request->has('sort_by')) $sort_by = 'encargado.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $encargados = Encargado::select('encargado.*', 'encargado.id as encargado_id', 'persona.*', 'empresa.nombre as empresa', 'area.puesto as puesto');
        $encargados ->join('persona', 'persona_id', '=', 'persona.id');
        $encargados ->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
        $encargados ->leftJoin('area', 'area_encargado.area_id', '=', 'area.id');
        $encargados ->leftJoin('empresa', 'area.empresa_id', '=', 'empresa.id');
  
        if ($request->has('nombre')) {
          $encargados->orWhere('nombre', 'LIKE', '%' . $request->nombre . '%');
        }  

        if ($request->has('apellido')) {
            $encargados->orWhere('apellido', 'LIKE', '%' . $request->apellido . '%');
        }  

        if ($request->has('colegiado')) {
            $encargados->orWhere('colegiado', 'LIKE', '%' . $request->colegiado . '%');
        }  
         
        if ($request->has('many')) {
          $encargados = $encargados->orderBy($sort_by, $direction)->paginate($many);          
        }
        else {
          $encargados = $encargados->orderBy($sort_by, $direction)->get();
        }

        $btn_nuevo = true;
        if(Auth::user()->rol->id == 2){          
            $encargados = $encargados->Where('usuario_id', Auth::user()->id);

            $encargado_est = Encargado::where('usuario_id', Auth::user()->id)->first();
            if($encargado_est){$btn_nuevo=false;}
        }
  
        //return response()->json($carreras);
        return view('encargados.index',compact(['encargados','btn_nuevo']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        $empresa = Empresa::where('usuario_id', Auth::user()->id)->first();

        if(Auth::user()->rol->id == 2){
            $encargado_est = Encargado::where('usuario_id', Auth::user()->id)->first();
            if($encargado_est){  abort(403);  }
        }

        return view('encargados.crear', compact(['empresa']));
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

        if((int)$request->solo_encargado){ //Ruta: encargado.crear
            
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->telefono = $request->telefono;
            $persona->correo = $request->correo;
            $persona->save();

            $encargado = new Encargado();
            $encargado->colegiado = $request->colegiado;
            $encargado->profesion = $request->profesion;
            $encargado->persona_id = $persona->id;
            $encargado->usuario_id = Auth::user()->id;
            $encargado->save();

            if($request->area){//SI el encargado es para una empresa que un estudiante ya ha ingresado
                $area = new Area();
                $area->nombre = $request->area;
                $area->puesto = $request->puesto;
                $area->empresa_id = $request->empresa_id;
                $area->save();
        
                $area_encargado =  new AreaEncargado();
                $area_encargado->area_id = $area->id;
                $area_encargado->encargado_id=$encargado->id;
                $area_encargado->save();
            }

            return redirect()->route('encargado.index')->with('creado', $encargado->id);   
        }
        else{ // Ruta empresa.encargado
            if($request->nuevo){
                $persona = new Persona();
                $persona->nombre = $request->nombre;
                $persona->apellido = $request->apellido;
                $persona->telefono = $request->telefono;
                $persona->correo = $request->correo;
                $persona->save();
    
                $encargado = new Encargado();
                $encargado->colegiado = $request->colegiado;
                $encargado->profesion = $request->profesion;
                $encargado->persona_id = $persona->id;
                $encargado->usuario_id = Auth::user()->id;
                $encargado->save();
    
                $encargado_id = $encargado->id;
            }
            else{
                $encargado_id=$request->encargado_id;
            }
    
            $area = new Area();
            $area->nombre = $request->area;
            $area->puesto = $request->puesto;
            $area->empresa_id = $request->empresa_id;
            $area->save();
    
            $area_encargado =  new AreaEncargado();
            $area_encargado->area_id = $area->id;
            $area_encargado->encargado_id=$encargado_id;
            $area_encargado->save();
    
            return redirect()->route('empresa.ver', $request->empresa_id);  
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function ver(Encargado $encargado)
    {
       Gate::authorize('haveaccess', $this->roles_gate );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function editar(Encargado $encargado)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $encargado = Encargado::findOrFail($request->id);
        $condicion = $encargado->delete();

        //return dd($request->id);
        return redirect()->route('encargado.index')->with('eliminado', true);
    }
}
