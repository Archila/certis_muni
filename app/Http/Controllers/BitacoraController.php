<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Encargado;
use App\Models\Carrera;
use App\Models\Bitacora;
use App\Models\Folio;
use App\Models\Area;
use App\Models\Revision;
use App\Models\AreaEncargado;
use App\Models\Estudiante;
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
            if(Auth::user()->rol->id == 3){
                $estudiantes->where('carrera.id', 1); //CIVIL
            }
            elseif(Auth::user()->rol->id == 4){
                $estudiantes->where('carrera.id', 2); //Mecanica
            }
            elseif(Auth::user()->rol->id == 5){
                $estudiantes->where('carrera.id', 3); //Industrial
            }
            elseif(Auth::user()->rol->id == 6){
                $estudiantes->where('carrera.id', 4); //Mecanica Industrial
            }
            elseif(Auth::user()->rol->id == 7){
                $estudiantes->where('carrera.id', 5); //Sistemas
            }
        }
        $estudiantes = $estudiantes->orderBy('estudiante.created_at', $direction)->get();

        return view('bitacoras.index',compact(['bitacoras','btn_nuevo', 'estudiantes']));
    }

    public function individual(Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 2 ]}' );
        
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
        
        if(Auth::user()->rol->id == 2){   
            $bitacora_est = Bitacora::where('usuario_id',Auth::user()->id)->first();
            if($bitacora_est){abort(403);}
            $empresas = Empresa::where('publico',1)->get();            
            $encargados = $encargados->get();            
        }
        else{
            $empresas = Empresa::all();
            $encargados = $encargados->get();
        }              
        
        $areas=null;        
        if(!$empresas->count()){ }
        else{
            $areas = Area::select('area.nombre as area', 'area.descripcion as descripcion');        
            $areas = $areas->join('empresa', 'area.empresa_id', '=', 'empresa.id');
            $areas = $areas->where('empresa.id',$empresas[0]->id)->get();
        }
        $empresa = Empresa::where('usuario_id', Auth::user()->id)->first();

        $encargado= Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id', 'area_encargado.puesto as puesto');
        $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
        $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id')->get();
        $encargado = $encargado->where('usuario_id', Auth::user()->id)->first();

        return view('bitacoras.crear', ['encargados'=>$encargados, 'empresas'=>$empresas, 'empresa'=>$empresa, 'encargado'=>$encargado, 'areas'=>$areas]);
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

        $bitacora = new Bitacora();
        $bitacora->semestre = $request->semestre;
        $bitacora->year = $request->year;
        $bitacora->tipo = $request->tipo;
        $bitacora->empresa_id = $request->empresa_id;
        $bitacora->encargado_id = $encargado_id;
        $bitacora->usuario_id = Auth::user()->id;
        $bitacora->save();

        if(Auth::user()->rol->id == 2){
            return redirect()->route('bitacora.individual')->with('creado', $bitacora->id);  
        }
        else{
            return redirect()->route('bitacora.index')->with('creado', $bitacora->id);  
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

        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $bitacora->usuario_id){abort(403);}
        }

        $folios = Folio::select('folio.*');
        $folios = $folios->where('bitacora_id',$bitacora->id);
        $folios = $folios->orderBy('numero')->get();

        $empresa = Empresa::where('id', $bitacora->empresa_id)->first();

        $encargado= Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id', 'area_encargado.puesto as puesto');
        $encargado = $encargado->join('persona', 'persona_id', '=', 'persona.id');
        $encargado = $encargado->leftJoin('area_encargado', 'encargado.id', '=', 'area_encargado.encargado_id');
        $encargado = $encargado->leftJoin('area', 'area_encargado.area_id', '=', 'area.id');
        $encargado = $encargado->where('encargado.id',  $bitacora->encargado_id)->first();

        $estudiante = Estudiante:: select('estudiante.*', 'estudiante.id as estudiante_id', 'persona.*', 'carrera.nombre as carrera');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->join('carrera', 'estudiante.carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->where('users.id', $bitacora->usuario_id)->firstOrFail();


        return view('bitacoras.ver',['bitacora'=>$bitacora, 'folios'=>$folios, 'empresa'=>$empresa, 'encargado'=>$encargado, 'estudiante'=>$estudiante]);
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
        if(!$bitacora->valida){        
            abort(403);
        }
        elseif(Auth::user()->id != $bitacora->usuario_id){        
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

    public function oficio($id)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );

        $bitacora = Bitacora::findOrFail($id);

        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $bitacora->usuario_id){abort(403);}
        }

        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera', 'carrera.id as carrera_id');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id',$bitacora->usuario_id)->first();
        
        if(Auth::user()->rol->id == 3 && $estudiante->carrera_id != 1){ abort(403);} // CIVIL
        elseif(Auth::user()->rol->id == 4 && $estudiante->carrera_id != 2   ){ abort(403);} // MECANICA
        elseif(Auth::user()->rol->id == 5 && $estudiante->carrera_id != 3){ abort(403);} // INDUSTRIAL
        elseif(Auth::user()->rol->id == 6 && $estudiante->carrera_id != 4){ abort(403);} // MECANICA INDUSTRIAL
        elseif(Auth::user()->rol->id == 7 && $estudiante->carrera_id != 5){ abort(403);} // SISTEMAS
        
        $oficio = 'EPS-';

        if($estudiante->carrera_id == 1){$oficio .= 'IC No. ';}
        elseif($estudiante->carrera_id == 2){$oficio .= 'IM No. ';}
        elseif($estudiante->carrera_id == 3){$oficio .= 'II No. ';}
        elseif($estudiante->carrera_id == 4){$oficio .= 'IMI No. ';}
        elseif($estudiante->carrera_id == 5 ){$oficio .= 'IS No. ';}

        $oficios_existentes = Bitacora::select('bitacora.*', 'carrera.id as carrera_id');
        $oficios_existentes = $oficios_existentes->join('users', 'bitacora.usuario_id', '=', 'users.id');
        $oficios_existentes = $oficios_existentes->join('persona', 'users.persona_id', '=', 'persona.id');
        $oficios_existentes = $oficios_existentes->join('estudiante', 'persona.id', '=', 'estudiante.persona_id');
        $oficios_existentes = $oficios_existentes->join('carrera', 'estudiante.carrera_id', '=', 'carrera.id');
        $oficios_existentes =  $oficios_existentes->where('carrera.id', $estudiante->carrera_id);
        $oficios_existentes =  $oficios_existentes->where('bitacora.oficio', 1)->count();

        if($oficios_existentes<9){$oficio .= '00'; $oficio .= (string)($oficios_existentes+1);}
        else {$oficio .= '0'; $oficio .= (string)($oficios_existentes+1);}

        $year = date('yy');

        $oficio .= '-'.(string)$year ;

        $bitacora->oficio = true;
        $bitacora->no_oficio = $oficio;
        $bitacora->save();

        return redirect()->route('bitacora.ver', $id)->with('oficio', true);    
    }

    public function validar($id)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $fecha = date('yy-m-d');
        $bitacora = Bitacora::findOrFail($id);

        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera', 'carrera.id as carrera_id');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id',$bitacora->usuario_id)->first();
        
        if(Auth::user()->rol->id == 3 && $estudiante->carrera_id != 1){ abort(403);} // CIVIL
        elseif(Auth::user()->rol->id == 4 && $estudiante->carrera_id != 2   ){ abort(403);} // MECANICA
        elseif(Auth::user()->rol->id == 5 && $estudiante->carrera_id != 3){ abort(403);} // INDUSTRIAL
        elseif(Auth::user()->rol->id == 6 && $estudiante->carrera_id != 4){ abort(403);} // MECANICA INDUSTRIAL
        elseif(Auth::user()->rol->id == 7 && $estudiante->carrera_id != 5){ abort(403);} // SISTEMAS

        $codigo="";
        if($estudiante->carrera_id == 1){$codigo .= 'BPFIC';}
        elseif($estudiante->carrera_id == 2){$codigo .= 'BPFIM';}
        elseif($estudiante->carrera_id == 3){$codigo .= 'BPFII';}
        elseif($estudiante->carrera_id == 4){$codigo .= 'BPFIMI';}
        elseif($estudiante->carrera_id == 5 ){$codigo .= 'BPFIS';}

        $bitacoras_validas = Bitacora::select('bitacora.*', 'carrera.id as carrera_id');
        $bitacoras_validas = $bitacoras_validas->join('users', 'bitacora.usuario_id', '=', 'users.id');
        $bitacoras_validas = $bitacoras_validas->join('persona', 'users.persona_id', '=', 'persona.id');
        $bitacoras_validas = $bitacoras_validas->join('estudiante', 'persona.id', '=', 'estudiante.persona_id');
        $bitacoras_validas = $bitacoras_validas->join('carrera', 'estudiante.carrera_id', '=', 'carrera.id');
        $bitacoras_validas =  $bitacoras_validas->where('carrera.id', $estudiante->carrera_id);
        $bitacoras_validas =  $bitacoras_validas->where('bitacora.valida', 1)->count();

        $mes = date('m');
        $year= date('yy');
        if($bitacoras_validas<9){$codigo.='0'; $codigo.=(string)($bitacoras_validas+1);}
        else{$codigo.=(string)($bitacoras_validas+1);}
        $codigo .= (string)$mes; $codigo.=(string)$year;
        $bitacora = Bitacora::findOrFail($id);
        $bitacora->valida = true;
        $bitacora->f_aprobacion = $fecha;  
        $bitacora->codigo = $codigo;      
        $bitacora->save();        
        
        return redirect()->route('bitacora.ver', $id)->with('valido', true);    
    }

    public function revisar($id)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $bitacora = Bitacora::findOrFail($id);

        $folios = Folio::select('folio.*');
        $folios = $folios->where('bitacora_id',$bitacora->id);
        $folios = $folios->orderBy('numero')->get();

        $revisiones =Revision::where('bitacora_id', $bitacora->id);
        $revisiones = $revisiones->orderBy('fecha')->get();

        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id',$bitacora->usuario_id)->first();
               
        return view('bitacoras.revisar', ['revisiones'=>$revisiones, 'folios'=>$folios, 'bitacora'=>$bitacora, 'estudiante'=>$estudiante]);
    }

    public function revision(Request $request, $id)
    {
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
        $revision->fecha = date('yy-m-d');
        $revision->ponderacion = $request->ponderacion;
        $revision->bitacora_id = $bitacora->id;
        $revision->save();

        return redirect()->route('bitacora.revisar', $id)->with('revision', true); 
    }
}
