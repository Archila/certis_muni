<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\Carrera;
use Illuminate\Http\Request;

class EstudianteController extends Controller
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
            'carne' => 'nullable|string',
            'registro' => 'nullable|string',
            'carrera_id' => 'nullable|string',
        ]);
  
        $many = 5;
        if($request->has('many')) $many = $request->many;
  
        $sort_by = 'estudiante.created_at';
        if($request->has('sort_by')) $sort_by = 'estudiante.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $estudiantes = Estudiante::select('estudiante.*', 'carrera.nombre as carrera', 'persona.*', 'estudiante.id as estudiante_id');

        $estudiantes ->join('carrera', 'carrera_id', '=', 'carrera.id');

        $estudiantes ->join('persona', 'persona_id', '=', 'persona.id');
  
        if ($request->has('nombre')) {
          $estudiantes->orWhere('nombre', 'LIKE', '%' . $request->nombre . '%');
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
         
        if ($request->has('many')) {
          $estudiantes = $estudiantes->orderBy($sort_by, $direction)->paginate($many);          
        }
        else {
          $estudiantes = $estudiantes->orderBy($sort_by, $direction)->get();
        }
  
        //return response()->json($carreras);
        return view('estudiantes.index',compact('estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        $carreras = Carrera::all();
        return view('estudiantes.crear',compact('carreras'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {    
        $estudiante = Estudiante::where('carne', '=',$request->carne)->orWhere('registro', '=',$request->registro)->first();

        if ($estudiante) {            
            return redirect()->route('estudiante.crear')->with('error', 'ERROR');             
        }        
        
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->telefono = $request->telefono;
        $persona->correo = $request->correo;
        $persona->save();

        $year = date('yy');
        
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
        $estudiante->save();
        
        return redirect()->route('estudiante.index')->with('creado', $estudiante->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function ver(Estudiante $estudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
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
    public function actualizar(Request $request)
    {
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
        $estudiante = Estudiante::findOrFail($request->id);
        $persona = Persona::findOrFail($estudiante->persona_id);
        $condicion = $persona->delete();

        //return dd($request->id);
        return redirect()->route('estudiante.index')->with('eliminado', true);
    }
}
