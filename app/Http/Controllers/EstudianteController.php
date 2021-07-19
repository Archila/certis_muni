<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\Carrera;
use App\Models\Supervisor;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Session;

class EstudianteController extends Controller
{
    private $roles_gate = '{"roles":[ 1, 3, 4, 5, 6, 7 ]}';
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

        if($request->has('year')) {
            $year=$request->year;
            Session::put('year', $year);
        } else {
            $year = Session::get('year');
        }
        if($request->has('semestre')) {
            $semestre=$request->semestre;
            Session::put('semestre', $semestre);
        } else {
            $semestre = Session::get('semestre');
        }
  
        $many = 5;
        if($request->has('many')) $many = $request->many;
  
        $sort_by = 'estudiante.created_at';
        if($request->has('sort_by')) $sort_by = 'estudiante.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $estudiantes = Estudiante::select('estudiante.*', 'carrera.nombre as carrera', 'persona.*', 'estudiante.id as estudiante_id', 'persona.id as persona_id');

        $estudiantes ->join('carrera', 'carrera_id', '=', 'carrera.id');

        $estudiantes ->join('persona', 'persona_id', '=', 'persona.id');

        $busqueda = $request->has('search')?$request->search:'';
  
        if ($request->has('search')) {
          $estudiantes->orWhere('persona.nombre', 'LIKE', '%' . $request->search . '%');
          $estudiantes->orWhere('persona.apellido', 'LIKE', '%' . $request->search . '%');
          $estudiantes->orWhere('carne', 'LIKE', '%' . $request->search . '%');
          $estudiantes->orWhere('registro', 'LIKE', '%' . $request->search . '%');
          $estudiantes->orWhere('carrera.nombre', 'LIKE', '%' . $request->search . '%');
        }  

        if ($request->has('apellido')) {
            $estudiantes->orWhere('apellido', 'LIKE', '%' . $request->apellido . '%');
        }  

        if ($request->has('carne')) {
            $estudiantes->orWhere('carne', 'LIKE', '%' . $request->carne . '%');
        }  

        if ($request->has('registro')) {
            $estudiantes->orWhere('registro', 'LIKE', '%' . $request->registro . '%');
        }  

        if ($request->has('carrera_id')) {
            $estudiantes->orWhere('carrera_id', $request->carrera_id);
        }  

        if(Auth::user()->rol->id != 1){
            if(Auth::user()->rol->id == 3){
                $estudiantes->orWhere('carrera_id', 1); //CIVIL
            }
            elseif(Auth::user()->rol->id == 4){
                $estudiantes->orWhere('carrera_id', 2); //Mecanica
            }
            elseif(Auth::user()->rol->id == 5){
                $estudiantes->orWhere('carrera_id', 3); //Industrial
            }
            elseif(Auth::user()->rol->id == 6){
                $estudiantes->orWhere('carrera_id', 4); //Mecanica Industrial
            }
            elseif(Auth::user()->rol->id == 7){
                $estudiantes->orWhere('carrera_id', 5); //Sistemas
            }
        }

        $estudiantes = $estudiantes->where('estudiante.year',$year);
        $estudiantes = $estudiantes->where('estudiante.semestre',$semestre);
         
        if ($request->has('many')) {
          $estudiantes = $estudiantes->orderBy($sort_by, $direction)->paginate($many);          
        }
        else {
          $estudiantes = $estudiantes->orderBy($sort_by, $direction)->get();
        }

        $usuarios = User::all();
  
        //return response()->json($carreras);
        return view('estudiantes.index',compact(['estudiantes', 'year', 'semestre','usuarios','busqueda']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $carreras = Carrera::all();

        $supervisores = Supervisor::select( 'users.id as usuario_id', 'supervisor.id as supervisor_id', 'persona.nombre as nombre', 'persona.apellido as apellido');
        $supervisores = $supervisores->join('persona', 'supervisor.persona_id','=','persona.id');
        $supervisores = $supervisores->join('users', 'persona.id','=','users.persona_id')->get();

        $carrera = null;

        if(Auth::user()->rol->id != 1){
            if(Auth::user()->rol->id == 3){ $carrera = Carrera::findOrFail(1);}
            if(Auth::user()->rol->id == 4){ $carrera = Carrera::findOrFail(2);}
            if(Auth::user()->rol->id == 5){ $carrera = Carrera::findOrFail(3);}
            if(Auth::user()->rol->id == 6){ $carrera = Carrera::findOrFail(4);}
            if(Auth::user()->rol->id == 7){ $carrera = Carrera::findOrFail(5);}
        }

        return view('estudiantes.crear',compact('carreras', 'supervisores', 'carrera'));
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

        $year = date('Y');
        /* 
        $request->validate([
            'carne' => 'required|unique:estudiante,carne',
            'registro' => 'required|unique:estudiante,registro',
        ]);*/

        $estudiante = Estudiante::where('carne', '=',$request->carne)->orWhere('registro', '=',$request->registro)->first();
        $duplicado=false;

        if ($estudiante) {  
            $duplicado =true;        
            //return redirect()->route('estudiante.crear')->with('error', 'ERROR');             
        }        

        if(Auth::user()->rol->id == 1){
            $usuario_supervisor = $request->usuario_supervisor;
        }
        else{
            $usuario_supervisor = Auth::user()->id;
        }

        //Operaciones con string
        $pos_n = strrpos(trim($request->nombre), " ");
        if($pos_n === false) {$solonombre = $request->nombre;}
        else{ $solonombre= substr($request->nombre, 0, $pos_n); }

        $pos_a = strrpos(trim($request->apellido), ' ');
        if($pos_a === false) { $soloapellido = $request->apellido;}
        else{ $soloapellido= substr($request->apellido, 0, $pos_a); }        

        $username = $solonombre . ' ' . $soloapellido;
        $ultimos_digitos=substr($request->registro, -3);

        $clave = strtolower($solonombre).strtolower($soloapellido).$ultimos_digitos;
        
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->telefono = $request->telefono;
        $persona->correo = $request->correo;
        $persona->save();
        
        $estudiante = new Estudiante();
        $estudiante->semestre = $request->semestre;
        $estudiante->carne = $request->carne;
        $estudiante->registro = $request->registro;
        $estudiante->promedio = $request->promedio;
        $estudiante->creditos = $request->creditos;
        $estudiante->practicas = $request->practicas;
        $estudiante->year = $year;
        $estudiante->direccion = $request->direccion;
        $estudiante->persona_id = $persona->id;
        $estudiante->carrera_id = $request->carrera_id;
        $estudiante->usuario_supervisor = $usuario_supervisor;
        $estudiante->duplicado = $duplicado;
        $estudiante->save();
        
        //usuario con rol de estudiante
        $usuario=new User();
        $usuario->name=$username;
        $usuario->email=$request->correo;
        $usuario->password=bcrypt($clave);
        if($duplicado){
            $usuario->carne = $request->registro.'_2';
        } else {
            $usuario->carne = $request->registro;
        }        
        $usuario->persona_id = $persona->id;
        $usuario->rol_id = 2;
        $usuario->save();

        return redirect()->route('estudiante.index')->with(['creado'=>$estudiante->id, 'duplicado'=>$duplicado]);   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function ver(Estudiante $estudiante)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $estudiante = Estudiante::select('estudiante.*', 'carrera.nombre as carrera', 'persona.*', 'estudiante.id as estudiante_id');
        $estudiante ->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante ->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->where('estudiante.id',$id)->firstOrFail();

        $carreras= Carrera::all();

        return view('estudiantes.editar', ['estudiante'=>$estudiante, 'carreras'=>$carreras]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, Estudiante $estudiante)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        /* 
        $request->validate([
            'carne' => 'required|unique:estudiante,carne,'.$estudiante->id,
            'registro' => 'required|unique:estudiante,registro,'.$estudiante->id,
        ]);*/

        $estudiante = Estudiante::where('registro',$request->registro)->where('estudiante.id','!=',$request->estudiante_id)->first();
        if ($estudiante) {            
            return redirect()->route('estudiante.editar', $request->id)->with('error','ERROR');             
        } 

        $estudiante = Estudiante::where('carne',$request->carne)->where('estudiante.id','!=',$request->estudiante_id)->first();
        if ($estudiante) {            
            return redirect()->route('estudiante.editar', $request->id)->with('error','ERROR');             
        } 

        $estudiante = Estudiante::findOrFail($request->id);

        $persona = Persona::findOrFail($estudiante->persona_id);
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->telefono = $request->telefono;
        $persona->correo = $request->correo;
        $persona->save();

        $estudiante->semestre = $request->semestre;
        $estudiante->carne = $request->carne;
        $estudiante->registro = $request->registro;
        $estudiante->promedio = $request->promedio;
        $estudiante->creditos = $request->creditos;
        $estudiante->practicas = $request->practicas;
        $estudiante->direccion = $request->direccion;
        $estudiante->persona_id = $persona->id;
        $estudiante->carrera_id = $request->carrera_id;
        $condicion = $estudiante->save();

        return redirect()->route('estudiante.index')->with('editado', $condicion);  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $estudiante = Estudiante::findOrFail($request->id);
        $persona = Persona::findOrFail($estudiante->persona_id);
        $condicion = $persona->delete();

        //return dd($request->id);
        return redirect()->route('estudiante.index')->with('eliminado', true);
    }
}
