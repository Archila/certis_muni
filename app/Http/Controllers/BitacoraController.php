<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Encargado;
use App\Models\Carrera;
use App\Models\Bitacora;
use App\Models\Folio;
use App\Models\Oficio;
use App\Models\Area;
use App\Models\Revision;
use App\Models\AreaEncargado;
use App\Models\Estudiante;
use Illuminate\Http\Request;

use App\Models\Configuracion;

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
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        
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
  
        $bitacoras = Bitacora::select('bitacora.*', 'persona.*', 'empresa.nombre as empresa', 'encargado.profesion as profesion', 
        'encargado.colegiado as colegiado', 'bitacora.id as bitacora_id', 'area_encargado.puesto as puesto');  
        $bitacoras->join('encargado', 'encargado_id', '=', 'encargado.id');
        $bitacoras->join('empresa', 'empresa_id', '=', 'empresa.id');
        $bitacoras->join('persona', 'encargado.persona_id', '=', 'persona.id');
        $bitacoras->join('area_encargado', 'area_encargado.encargado_id', '=', 'encargado.id');
        $bitacoras->join('area', 'area.id', '=', 'area_encargado.area_id');
         
        if ($request->has('year')) {
          $bitacoras->orWhere('year', '=', $request->codigo);
        }
  
        if ($request->has('many')) {
          $bitacoras = $bitacoras->orderBy($sort_by, $direction)->paginate($many);          
        }
        else {
          $bitacoras = $bitacoras->orderBy($sort_by, $direction)->get();
        }

        $bitacora=[];

        $btn_nuevo = true;
        if(Auth::user()->rol->id == 2){   
            $bitacoras= $bitacoras->Where('usuario_id', Auth::user()->id);

            $bitacora_est = Bitacora::where('usuario_id', Auth::user()->id)->first();
            if($bitacora_est){$btn_nuevo=false;}
        }

        $estudiantes = Estudiante::select('estudiante.*', 'carrera.nombre as carrera', 'persona.*', 'estudiante.id as estudiante_id',
        'users.id as usuario_id');
        $estudiantes ->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiantes ->join('persona', 'persona_id', '=', 'persona.id');
        $estudiantes ->join('users', 'persona.id', '=', 'users.persona_id');

        if(Auth::user()->rol->id != 1){
            $estudiantes = $estudiantes->where('usuario_supervisor',Auth::user()->id);
        }
        $estudiantes = $estudiantes->orderBy('estudiante.created_at', $direction)->get();

        //return dd(Auth::user());

        return view('bitacoras.index',compact(['bitacoras','btn_nuevo', 'estudiantes']));
    }

    public function individual(Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 2 ]}' );

        return(Auth::user());
        
        $bitacora = Bitacora::where('usuario_id',Auth::user()->id)->first();        

        if($bitacora){
            if(Auth::user()->rol->id == 2){        
                if(Auth::user()->id != $bitacora->usuario_id){abort(403);}
            }

            $empresa = Empresa::where('id', $bitacora->empresa_id)->first();

            $encargado= Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id', 'area_encargado.puesto as puesto');
            $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
            $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
            $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id');
            $encargado = $encargado->where('encargado.id', $bitacora->encargado_id)->first();

            $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera');
            $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
            $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
            $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
            $estudiante = $estudiante->where('users.id',$bitacora->usuario_id)->first();

            $folios = Folio::where('bitacora_id', $bitacora->id)->orderBy('numero', 'asc')->get();

            //$encargado = Encargado::findOrFail($bitacora->encargado_id);
            //return dd($encargado);

            return view('bitacoras.individual', ['nuevo'=>false,'empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora, 'estudiante'=>$estudiante, 'folios'=>$folios]);
        }
        else{
            return view('bitacoras.individual', ['nuevo'=>true]);
        }
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

        $oficio = Oficio::where('revisado',1)->where('rechazado',0)->where('usuario_id', Auth::user()->id)->first();
        
        if(Auth::user()->rol->id == 2){   
            $bitacora_est = Bitacora::select('bitacora.*', 'oficio.usuario_id as usuario_id');
            $bitacora_est = $bitacora_est->join('oficio','bitacora.oficio_id', 'oficio.id');
            $bitacora_est = $bitacora_est->where('oficio.usuario_id',Auth::user()->id)->first();
            if($bitacora_est){abort(403);}            
            $encargados = $encargados->get();            
        }
        else{
            $empresas = Empresa::all();
            $encargados = $encargados->get();
        }              
        
        $areas=null;        
        
        $empresa = Empresa::where('id',$oficio->empresa_id)->first();

        $encargado= Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id', 'area_encargado.puesto as puesto');
        $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
        $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id')->get();
        $encargado = $encargado->where('usuario_id', Auth::user()->id)->first();

        return view('bitacoras.crear', ['encargados'=>$encargados, 'empresa'=>$empresa, 'encargado'=>$encargado, 'areas'=>$areas, 'oficio'=>$oficio]);
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
        $oficio = Oficio::findOrFail($request->oficio_id);

        $year = date('Y');
        $semestre = 1;
        if(date('M')>6){$semestre = 2;}

        if(!$oficio->revisado || $oficio->rechazado){
            abort(403);
        }

        if($request->existente){
            $encargado_id = $request->encargado_area_id;            
        }
        else{
            $encargado_id = $request->encargado_id;
            $area_encargado =  new AreaEncargado();
            $area_encargado->puesto = $request->puesto;
            $area_encargado->area_id = $request->area_id;
            $area_encargado->encargado_id=$encargado_id;
            $area_encargado->save();
        }

        $nombre = "";
        if($oficio->tipo == 1){$nombre = "Práctica final en docencia";}
        else if($oficio->tipo == 2){$nombre = "Práctica final en investigación";}
        else if($oficio->tipo == 3){$nombre = "Práctica final aplicada";}

        if($oficio->semestre == 1){$nombre .= " - Primer semestre ".(string)$oficio->year;}
        else{$nombre .= " - Segundo semestre ".(string)$oficio->year;}

        $fecha = date('Y-m-d');
        
        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera', 'carrera.id as carrera_id');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id',$oficio->usuario_id)->first();

        //Codigo de bitacora
        $codigo="";
        if($estudiante->carrera_id == 1){$codigo .= 'BPFIC-';}
        elseif($estudiante->carrera_id == 2){$codigo .= 'BPFIM-';}
        elseif($estudiante->carrera_id == 3){$codigo .= 'BPFII-';}
        elseif($estudiante->carrera_id == 4){$codigo .= 'BPFIMI-';}
        elseif($estudiante->carrera_id == 5 ){$codigo .= 'BPFIS-';}

        $configuracion = Configuracion::where('nombre','=','correlativo_bitacora');
        $configuracion = $configuracion->where('tipo','=',$estudiante->carrera_id)->get()->first();

        $bitacoras_validas = $configuracion->valor;

        $mes = date('m');
        $year= date('Y');
        if($bitacoras_validas<9){$codigo.='0'; $codigo.=(string)($bitacoras_validas+1);}
        else{$codigo.=(string)($bitacoras_validas+1);}
        $codigo.= '-'.(string)$year;

        $bitacora = new Bitacora();
        $bitacora->nombre = $nombre;   
        $bitacora->codigo = $codigo;
        $bitacora->encargado_id = $encargado_id;
        $bitacora->oficio_id = $oficio->id;
        $bitacora->save();

        $configuracion->valor = $configuracion->valor+1;
        $configuracion->save();

        return redirect()->route('practica.index')->with('creado', $bitacora->id);  

        if(Auth::user()->rol->id == 2){
            return redirect()->route('bitacora.individual')->with('creado', $bitacora->id);  
        }    
        else{
            return redirect()->route('bitacora.index');  
        }       
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
        $oficio = Oficio::findOrFail($bitacora->oficio_id);

        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $oficio->usuario_id){abort(403);}
        }

        $folios = Folio::select('folio.*');
        $folios = $folios->where('bitacora_id',$bitacora->id);
        $folios = $folios->orderBy('numero')->get();

        $empresa = Empresa::where('id', $oficio->empresa_id)->first();

       
        $encargado= Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id', 'area_encargado.puesto as puesto');
        $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
        $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id');
        $encargado = $encargado->where('encargado.id',  $bitacora->encargado_id)->first();

        $estudiante = Estudiante:: select('estudiante.*', 'estudiante.id as estudiante_id', 'persona.*', 'carrera.nombre as carrera');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->join('carrera', 'estudiante.carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->where('users.id', $oficio->usuario_id)->firstOrFail();
       
        if(Auth::user()->rol->id != 1 && Auth::user()->rol->id != 2){        
            if(Auth::user()->id != $estudiante->usuario_supervisor){abort(403);}
        }

        return view('bitacoras.ver',compact(['bitacora', 'folios', 'empresa', 'encargado', 'estudiante', 'oficio']));
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
        
    }

    public function crear_folio($id)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $bitacora = Bitacora::findOrFail($id); 
        $oficio = Oficio::findOrFail($bitacora->oficio_id);
        if(Auth::user()->id != $oficio->usuario_id){        
            abort(403);
        }    

        $folios = Folio::select('folio.*');
        $folios = $folios->where('bitacora_id',$bitacora->id);
        $folios = $folios->orderBy('numero')->get();


        return view('bitacoras.crear_folio',['bitacora'=>$bitacora, 'folios'=>$folios]);
    }

    public function pdf($id)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}' );

        $bitacora = Bitacora::findOrFail($id);

        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $bitacora->usuario_id){abort(403);}
        }

        $empresa = Empresa::where('usuario_id', Auth::user()->id)->first();

        $encargado= Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id', 'area_encargado.puesto as puesto');
        $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
        $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id')->get();
        $encargado = $encargado->where('usuario_id', $bitacora->usuario_id)->first();

        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id',$bitacora->usuario_id)->first();

        return view('bitacoras.pdf', ['empresa'=>$empresa, 'encargado'=>$encargado, 'bitacora'=>$bitacora, 'estudiante'=>$estudiante]);

    }

    public function validar($id)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $fecha = date('Y-m-d');
        $bitacora = Bitacora::findOrFail($id);

        $year = date('Y');
        $semestre = 1;
        if(date('M')>6){$semestre = 2;}

        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera', 'carrera.id as carrera_id');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id',$bitacora->usuario_id)->first();
        
        if(Auth::user()->rol->id != 1){        
            if(Auth::user()->id != $estudiante->usuario_supervisor){abort(403);}
        }

        $codigo="";
        if($estudiante->carrera_id == 1){$codigo .= 'BPFIC-';}
        elseif($estudiante->carrera_id == 2){$codigo .= 'BPFIM-';}
        elseif($estudiante->carrera_id == 3){$codigo .= 'BPFII-';}
        elseif($estudiante->carrera_id == 4){$codigo .= 'BPFIMI-';}
        elseif($estudiante->carrera_id == 5 ){$codigo .= 'BPFIS-';}

        $configuracion = Configuracion::where('nombre','=','correlativo_bitacora');
        $configuracion = $configuracion->where('tipo','=',$estudiante->carrera_id)->get()->first();

        $bitacoras_validas = $configuracion->valor;

        $mes = date('m');
        $year= date('Y');
        if($bitacoras_validas<9){$codigo.='0'; $codigo.=(string)($bitacoras_validas+1);}
        else{$codigo.=(string)($bitacoras_validas+1);}
        $codigo.= '-'.(string)$year;
        $bitacora = Bitacora::findOrFail($id);
        $bitacora->valida = true;
        $bitacora->f_aprobacion = $fecha;  
        $bitacora->codigo = $codigo;      
        $bitacora->save();        

        $configuracion->valor = $configuracion->valor+1;
        $configuracion->save();
        
        return redirect()->route('bitacora.ver', $id)->with('valido', true);    
    }

    public function revisar($id)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $bitacora = Bitacora::findOrFail($id);
        $oficio = Oficio::findOrFail($bitacora->oficio_id);
        $folios = Folio::select('folio.*');
        $folios = $folios->where('bitacora_id',$bitacora->id);
        $folios = $folios->orderBy('numero')->get();

        $revisiones =Revision::where('bitacora_id', $bitacora->id);
        $revisiones = $revisiones->orderBy('fecha')->get();

        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id',$oficio->usuario_id)->first();
               
        return view('bitacoras.revisar', ['revisiones'=>$revisiones, 'folios'=>$folios, 'bitacora'=>$bitacora, 'estudiante'=>$estudiante]);
    }

    public function revision(Request $request, $id)
    {
        $year = date('Y');
        $semestre = 1;
        if(date('M')>6){$semestre = 2;}

        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );

        $bitacora = Bitacora::findOrFail($id);

        $folios = Folio::select('folio.*');
        $folios = $folios->where('bitacora_id',$bitacora->id);
        $folios = $folios->where('revisado', 0);
        $folios = $folios->whereBetween('numero', [$request->folio_inicial, $request->folio_final]);
        $folios = $folios->orderBy('numero')->get();

        $horas =0;
        foreach($folios as $folio){
            $folio->revisado = 1;
            $horas += $folio->horas;
            $folio->save();
        }

        $revision = new Revision();
        $revision->numero = (Revision::where('bitacora_id', $bitacora->id)->count())+1;
        $revision->folio_inicial = $request->folio_inicial;
        $revision->folio_final = $request->folio_final;
        $revision->horas = $horas;
        $revision->observaciones = $request->observaciones;
        $revision->fecha = date('Y-m-d');
        $revision->ponderacion = $request->ponderacion;
        $revision->bitacora_id = $bitacora->id;
        $revision->save();

        return redirect()->route('bitacora.revisar', $id)->with('revision', true); 
    }

    public function fecha_extension($id, Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $bitacora = Bitacora::findOrFail($request->id);

        $bitacora->f_aprobacion = $request->fecha;
        $bitacora->save();
               
        return redirect()->route('bitacora.ver',$bitacora->id);
    }

    public function puesto($id, Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $bitacora = Bitacora::findOrFail($request->id);

        $bitacora->puesto = $request->puesto;
        $bitacora->save();
               
        return redirect()->route('bitacora.ver',$bitacora->id);
    }

    public function fecha_inicio($id, Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $bitacora = Bitacora::findOrFail($request->id);

        $bitacora->fecha_inicio = $request->fecha;
        $bitacora->save();
               
        return redirect()->route('bitacora.ver',$bitacora->id);
    }

    public function encargado($id, Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $bitacora = Bitacora::findOrFail($request->id);

        $bitacora->encargado = $request->nombre;
        $bitacora->save();
               
        return redirect()->route('bitacora.ver',$bitacora->id);
    }

    public function correo($id, Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $bitacora = Bitacora::findOrFail($request->id);

        $bitacora->correo = $request->correo;
        $bitacora->save();
               
        return redirect()->route('bitacora.ver',$bitacora->id);
    }
}
