<?php

namespace App\Http\Controllers;

use App\Encargado;
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
  
        $sort_by = 'estudiante.created_at';
        if($request->has('sort_by')) $sort_by = 'estudiante.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $estudiantes = Estudiante::select('estudiante.*', 'carrera.nombre as carrera', 'persona.*');

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
          $estudiantes = $carrestudianteseras->orderBy($sort_by, $direction)->paginate($many);          
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function show(Encargado $encargado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function edit(Encargado $encargado)
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
    public function update(Request $request, Encargado $encargado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Encargado $encargado)
    {
        //
    }
}
