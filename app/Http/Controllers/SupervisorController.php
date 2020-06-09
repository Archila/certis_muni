<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use App\Models\Persona;
use Illuminate\Http\Request;

class SupervisorController extends Controller
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
        //$carreras = Carrera::all();
        return view('supervisores.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        $supervisor = Supervisor::where('colegiado',$request->colegiado)->first();

        if ($supervisor) {            
            return redirect()->route('estudiante.crear')->with('error', 'ERROR');             
        }        
        
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->telefono = $request->telefono;
        $persona->correo = $request->correo;
        $persona->save();

        $supervisor = new Supervisor();
        $supervisor->profesion = $request->profesion;
        $supervisor->colegiado = $request->colegiado;
        $supervisor->persona_id = $persona->id;
        $supervisor->save();
        
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supervisor  $supervisor
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
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
        $supervisor = Supervisor::findOrFail($request->id);
        $persona = Persona::findOrFail($supervisor->persona_id);
        $condicion = $persona->delete();

        //return dd($request->id);
        return redirect()->route('supervisor.index')->with('eliminado', true);
    }
}
