<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Area;
use App\Models\TipoEmpresa;
use App\Models\Encargado;
use App\Models\Persona;
use App\Models\AreaEncargado;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

class EmpresaController extends Controller
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
            'carne' => 'nullable|string',
            'registro' => 'nullable|string',
            'carrera_id' => 'nullable|string',
        ]);
  
        $many = 5;
        if($request->has('many')) $many = $request->many;
  
        $sort_by = 'empresa.created_at';
        if($request->has('sort_by')) $sort_by = 'empresa.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $empresas = Empresa::select('empresa.*', 'tipo_empresa.nombre as tipo', 'empresa.id as empresa_id');

        $empresas ->join('tipo_empresa', 'tipo_empresa_id', '=', 'tipo_empresa.id');
  
        if ($request->has('nombre')) {
          $empresas->orWhere('nombre', 'LIKE', '%' . $request->nombre . '%');
        }  

        if ($request->has('alias')) {
            $empresas->orWhere('alias', 'LIKE', '%' . $request->alias . '%');
        }  

        if ($request->has('carne')) {
            $empresas->orWhere('carne', 'LIKE', '%' . $request->carne . '%');
        }  

        if ($request->has('registro')) {
            $empresas->orWhere('registro', 'LIKE', '%' . $request->registro . '%');
        }  

        if ($request->has('carrera_id')) {
            $empresas->orWhere('carrera_id', $request->carrera_id);
        }  

        $btn_nuevo = true;
        if(Auth::user()->rol->id == 2){            
            $empresas->Where('publico', 1);
            $empresas->orWhere('usuario_id', Auth::user()->id);

            $empresa_est = Empresa::where('usuario_id', Auth::user()->id)->first();
            if($empresa_est){$btn_nuevo=false;}
        }
         
        if ($request->has('many')) {
          $empresas = $empresas->orderBy($sort_by, $direction)->paginate($many);          
        }
        else {
          $empresas = $empresas->orderBy($sort_by, $direction)->get();
        }

        
  
        //return response()->json($carreras);
        return view('empresas.index',compact(['empresas', 'btn_nuevo']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        Gate::authorize('haveaccess', $this->roles_gate );
        $encargado = Encargado::select('encargado.*', 'encargado.id as encargado_id', 'persona.*');
        $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->where('usuario_id', Auth::user()->id)->first();
        $tipos = TipoEmpresa::where('activo',1)->get();

        if(Auth::user()->rol->id == 2){
            $empresa_est = Empresa::where('usuario_id', Auth::user()->id)->first();
            if($empresa_est){  abort(403);  }
        }

        return view('empresas.crear',compact(['tipos', 'encargado']));
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

        $empresa = Empresa::where('nombre', '=',$request->nombre)->first();        

        if ($empresa) {            
            return redirect()->route('empresa.crear')->with('error', 'ERROR');             
        }                

        if(Auth::user()->rol->id == 2){
            $empresa_est = Empresa::where('usuario_id', Auth::user()->id)->first();
            if($empresa_est){ return redirect()->route('empresa.index')->with('duplicado', 1);    }
        }
              
        $empresa = new Empresa();
        $empresa->nombre = $request->nombre;
        $empresa->direccion = $request->direccion;
        $empresa->ubicacion = $request->ubicacion;
        $empresa->alias = $request->alias;
        $empresa->correo = $request->correo;
        $empresa->telefono = $request->telefono;
        $empresa->contacto = $request->contacto;
        $empresa->tel_contacto = $request->tel_contacto;
        $empresa->correo_contacto = $request->correo_contacto;
        $empresa->tipo_empresa_id = $request->tipo_empresa_id;        
        $empresa->usuario_id = Auth::user()->id;
        $empresa->save();

        if($request->cbx_encargado){
            $persona = new Persona();
            $persona->nombre = $request->nombre_encargado;
            $persona->apellido = $request->apellido;
            $persona->telefono = $request->telefono_encargado;
            $persona->correo = $request->correo;
            $persona->save();

            $encargado = new Encargado();
            $encargado->colegiado = $request->colegiado;
            $encargado->profesion = $request->profesion;
            $encargado->persona_id = $persona->id;
            $encargado->usuario_id = Auth::user()->id;
            $encargado->save();

            $area = new Area();
            $area->nombre = $request->area;
            $area->puesto = $request->puesto;
            $area->empresa_id = $empresa->id;
            $area->save();
    
            $area_encargado =  new AreaEncargado();
            $area_encargado->area_id = $area->id;
            $area_encargado->encargado_id=$encargado->id;
            $area_encargado->save();
        }

        if($request->encargado_id){
            $area = new Area();
            $area->nombre = $request->area;
            $area->puesto = $request->puesto;
            $area->empresa_id = $empresa->id;
            $area->save();
    
            $area_encargado =  new AreaEncargado();
            $area_encargado->area_id = $area->id;
            $area_encargado->encargado_id=$request->encargado_id;
            $area_encargado->save();
        }
        
        return redirect()->route('empresa.index')->with('creado', $empresa->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $empresa = Empresa::select('empresa.*', 'tipo_empresa.nombre as tipo', 'empresa.id as empresa_id');
        $empresa ->join('tipo_empresa', 'tipo_empresa_id', '=', 'tipo_empresa.id');
        $empresa = $empresa->where('empresa.id',$id)->firstOrFail();

        $areas = Area::select('area.nombre as area', 'encargado.*', 'area.id as area_id', 'encargado.id as encargado_id', 'persona.*');
        $areas ->join('area_encargado', 'area.id', '=', 'area_encargado.area_id');
        $areas ->join('encargado', 'area_encargado.encargado_id', '=', 'encargado.id');
        $areas ->join('empresa', 'area.empresa_id', '=', 'empresa.id');
        $areas ->join('persona', 'encargado.persona_id', '=', 'persona.id');
        $areas = $areas->where('empresa.id',$id)->get();

        //return dd($areas);
        return view('empresas.ver', ['empresa'=>$empresa]);
    }   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        $areas = Area::select('area.nombre as area', 'encargado.*', 'area.id as area_id', 'encargado.id as encargado_id', 'persona.*');
        $areas ->join('area_encargado', 'area.id', '=', 'area_encargado.area_id');
        $areas ->join('encargado', 'area_encargado.encargado_id', '=', 'encargado.id');
        $areas ->join('empresa', 'area.empresa_id', '=', 'empresa.id');
        $areas ->join('persona', 'encargado.persona_id', '=', 'persona.id');
        $areas = $areas->where('empresa.id',$id)->get();

        $empresa = Empresa::select('empresa.*', 'tipo_empresa.nombre as tipo', 'empresa.id as empresa_id');
        $empresa ->join('tipo_empresa', 'tipo_empresa_id', '=', 'tipo_empresa.id');
        $empresa = $empresa->where('empresa.id',$id)->firstOrFail();

        $tipos= TipoEmpresa::where('activo',1)->get();
                
        Gate::authorize('haveaccess', $this->roles_gate );

        if(Auth::user()->rol->id == 2){            
            $empresa_est = Empresa::where('usuario_id')->first();
            if(Auth::user()->id != $empresa->usuario_id){abort(403);}
        }

        return view('empresas.editar', ['empresa'=>$empresa, 'tipos'=>$tipos, 'areas'=>$areas ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $empresa = Empresa::where('id','!=',$request->id)->where('nombre', '=',$request->nombre)->first();

        if ($empresa) {            
            return redirect()->route('empresa.editar', $request->id)->with('error', 'ERROR');             
        }                
              
        $empresa = Empresa::findOrFail($request->id);;
        $empresa->nombre = $request->nombre;
        $empresa->direccion = $request->direccion;
        $empresa->ubicacion = $request->ubicacion;
        $empresa->alias = $request->alias;
        $empresa->correo = $request->correo;
        $empresa->telefono = $request->telefono;
        $empresa->contacto = $request->contacto;
        $empresa->tel_contacto = $request->tel_contacto;
        $empresa->correo_contacto = $request->correo_contacto;
        $empresa->tipo_empresa_id = $request->tipo_empresa_id;  
        $empresa->calificacion = $request->calificacion;
        if($request->publico){ $publico=1; } else { $publico=0;}
        if($request->valido){ $valido=1; } else { $valido=0;}
        $empresa->publico = $publico;
        $empresa->valido = $valido;
        $condicion=$empresa->save();
        
        return redirect()->route('empresa.index')->with('editado', $condicion);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $empresa = Empresa::findOrFail($request->id);
        $condicion = $empresa->delete();

        //return dd($request->id);
        return redirect()->route('empresa.index')->with('eliminado', true);
    }

    public function encargado($id)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $empresa = Empresa::select('empresa.*', 'tipo_empresa.nombre as tipo', 'empresa.id as empresa_id');
        $empresa ->join('tipo_empresa', 'tipo_empresa_id', '=', 'tipo_empresa.id');
        $empresa = $empresa->where('empresa.id',$id)->firstOrFail();

        $encargados= Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id');
        $encargados ->join('persona', 'persona_id', '=', 'persona.id');
        $encargados = $encargados->get();

        return view('empresas.encargado', ['empresa'=>$empresa, 'encargados'=>$encargados]);
    }


}
