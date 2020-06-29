<?php

namespace App\Http\Controllers;

use App\Models\Encargado;
use App\Models\Area;
use App\Models\Persona;
use App\Models\AreaEncargado;
use Illuminate\Http\Request;

class EncargadoController extends Controller
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
            'colegiado' => 'nullable|string',
        ]);

        $many = 5;
        if($request->has('many')) $many = $request->many;
  
        $sort_by = 'encargado.created_at';
        if($request->has('sort_by')) $sort_by = 'encargado.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $encargados = Encargado::select('encargado.*', 'encargado.id as encargado_id', 'persona.*', 'empresa.nombre as empresa');
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
  
        //return response()->json($carreras);
        return view('encargados.index',compact('encargados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('encargados.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {          
        if((int)$request->solo_encargado){
            
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->telefono = $request->telefono;
            $persona->correo = $request->correo;
            $persona->save();

            $encargado = new Encargado();
            $encargado->colegiado = $request->colegiado;
            $encargado->profesion = $request->profesion;
            $encargado->puesto = $request->puesto;
            $encargado->persona_id = $persona->id;
            $encargado->save();

            return redirect()->route('encargado.index')->with('creado', $encargado->id);   
        }
        else{
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
                $encargado->puesto = $request->puesto;
                $encargado->persona_id = $persona->id;
                $encargado->save();
    
                $encargado_id = $encargado->id;
            }
            else{
                $encargado_id=$request->encargado_id;
            }
    
            $area = new Area();
            $area->nombre = $request->area;
            $area->descripcion = $request->descripcion;
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
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function editar(Encargado $encargado)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request)
    {
        $encargado = Encargado::findOrFail($request->id);
        $condicion = $encargado->delete();

        //return dd($request->id);
        return redirect()->route('encargado.index')->with('eliminado', true);
    }
}
