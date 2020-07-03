<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use App\Models\Persona;
use App\Models\Carrera;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;

class SupervisorController extends Controller
{
    private $roles_gate = '{"roles":[ 1 ]}';

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
            'profesion' => 'nullable|string',
            'colegiado' => 'nullable|string',
        ]);
  

        $many = 5;
        if($request->has('many')) $many = $request->many;
  
        $sort_by = 'supervisor.created_at';
        if($request->has('sort_by')) $sort_by = 'supervisor.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $supervisores = Supervisor::select('supervisor.*', 'persona.*', 'supervisor.id as supervisor_id');
        $supervisores ->join('persona', 'persona_id', '=', 'persona.id');
  
        if ($request->has('nombre')) {
          $supervisores->orWhere('nombre', 'LIKE', '%' . $request->nombre . '%');
        }  

        if ($request->has('apellido')) {
            $supervisores->orWhere('apellido', 'LIKE', '%' . $request->apellido . '%');
        }  

        if ($request->has('colegiado')) {
            $supervisores->orWhere('colegiado', 'LIKE', '%' . $request->colegiado . '%');
        }  

        if ($request->has('profesion')) {
            $supervisores->orWhere('profesion', 'LIKE', '%' . $request->profesion . '%');
        }  
         
        if ($request->has('many')) {
          $supervisores = $supervisores->orderBy($sort_by, $direction)->paginate($many);          
        }
        else {
          $supervisores = $supervisores->orderBy($sort_by, $direction)->get();
        }
  
        //return response()->json($carreras);
        return view('supervisores.index',compact('supervisores'));
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
        //$carreras = Carrera::all();
        return view('supervisores.crear', compact('carreras'));
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

        $supervisor = Supervisor::where('colegiado',$request->colegiado)->first();

        if ($supervisor) {            
            return redirect()->route('supervisor.crear')->with('error', 'ERROR');             
        }        

        //Operaciones con string
        $pos_n = strrpos(trim($request->nombre), " ");
        if($pos_n === false) {$solonombre = $request->nombre;}
        else{ $solonombre= substr($request->nombre, 0, $pos_n); }

        $pos_a = strrpos(trim($request->apellido), ' ');
        if($pos_a === false) { $soloapellido = $request->apellido;}
        else{ $soloapellido= substr($request->apellido, 0, $pos_a); }        

        $username = $solonombre . ' ' . $soloapellido;
        $ultimos_digitos=substr((string)$request->colegiado, -3);
        $clave = strtolower($solonombre).strtolower($soloapellido).$ultimos_digitos;

        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->telefono = $request->telefono;
        $persona->correo = $request->correo;
        $persona->save();

        $supervisor = new Supervisor();
        $supervisor->profesion = $request->profesion;
        $supervisor->clave = $clave;
        $supervisor->colegiado = $request->colegiado;
        $supervisor->persona_id = $persona->id;
        $supervisor->save();

        if($request->carrera_id == 1 ) {$rol = 3;} //Civil
        elseif($request->carrera_id == 2) {$rol = 4;} // Mecanica
        elseif($request->carrera_id == 3) {$rol = 5;} // Industrial
        elseif($request->carrera_id == 4) {$rol = 6;} // Mecanica - Industrial
        elseif($request->carrera_id == 5) {$rol = 7;} // Sistemas

        //usuario con rol de supervisor
        $usuario=new User();
        $usuario->name=$username;
        $usuario->email=$request->correo;
        $usuario->password=bcrypt($clave);
        $usuario->carne = $request->colegiado;
        $usuario->persona_id = $persona->id;
        $usuario->rol_id = $rol;
        $usuario->save();
        
        return redirect()->route('supervisor.index')->with('creado', $supervisor->id);   
  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supervisor  $supervisor
     * @return \Illuminate\Http\Response
     */
    public function show(Supervisor $supervisor)
    {
        Gate::authorize('haveaccess', $this->roles_gate );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supervisor  $supervisor
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $supervisor = Supervisor::select('supervisor.*', 'persona.*', 'supervisor.id as supervisor_id');        
        $supervisor ->join('persona', 'persona_id', '=', 'persona.id');
        $supervisor = $supervisor->where('supervisor.id',$id)->firstOrFail();

        return view('supervisores.editar', ['supervisor'=>$supervisor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supervisor  $supervisor
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {   
        Gate::authorize('haveaccess', $this->roles_gate );

        $supervisor = Supervisor::where('id','!=',$request->id)->where('colegiado',$request->colegiado)->get();

        if (count($supervisor)>0) {            
            return redirect()->route('supervisor.editar', $request->id)->with('error','ERROR');             
        } 

        $supervisor = Supervisor::findOrFail($request->id);

        $persona = Persona::findOrFail($supervisor->persona_id);
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->telefono = $request->telefono;
        $persona->correo = $request->correo;
        $persona->save();

        $supervisor->profesion = $request->profesion;
        $supervisor->colegiado = $request->colegiado;
        $supervisor->persona_id = $persona->id;
        $condicion = $supervisor->save();

        return redirect()->route('supervisor.index')->with('editado', $condicion);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supervisor  $supervisor
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request)
    {
        Gate::authorize('haveaccess', $this->roles_gate );

        $supervisor = Supervisor::findOrFail($request->id);
        $persona = Persona::findOrFail($supervisor->persona_id);
        $condicion = $persona->delete();

        //return dd($request->id);
        return redirect()->route('supervisor.index')->with('eliminado', true);
    }
}
