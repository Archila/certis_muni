<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Función que devuelve las personas en el sistema
     * 
     * Parámetros opcionales:
     * @param boolean $all - Valor para devolver la lista sin paginación
     * @param int $many - Cantidad de objetos por página
     * @param string $sort_by - Columna por la que se va a ordenar
     * @param string $direction - Dirección del orden
     * @param string $nombre - Nombre de la persona
     * @param string $apellido - Apellido de la persona
     *  
     * @return array $personas - Lista de las perosnas
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
        ]);

        $many = 5;
        if($request->has('many')) $many = $request->many;

        $sort_by = 'tour.id';
        if($request->has('sort_by')) $sort_by = 'tour.'.$request->sort_by;

        $direction = 'asc';
        if($request->has('direction')) $direction = $request->direction;

        $personas = Persona::orderBy($sort_by, $direction);     
                
        if ($request->has('nombre')) {
            $personas->Where('persona.nombre', 'LIKE', '%' . $request->nombre . '%');
        }

        if ($request->has('nombre')) {
            $personas->Where('persona.apellido', 'LIKE', '%' . $request->apellido . '%');
        }
        
        if ($request->has('all')) {
            $personas = $personas->orderBy($sort_by, $direction)->get();
        }
        else {
            $personas = $personas->orderBy($sort_by, $direction)->paginate($many);
        }
        
        return response()->json($personas);
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
     * Función para agregar una persona
     * 
     * Parámetros requeridos:
     * @param string $nombre - Nombre de la persona
     * @param string $apellido - Apellido de la persona
     * @param string $correo - Correo de la persona
     * @param string $telefono - Telefono de la persona
     * 
     * @return int $id - Id de la persona guardada
    */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'correo' => 'required|string',
            'telefono' => 'required|string',
        ]);

        $carrera = Carrera::where('apellido', $request->apellido)->where('apellido', $request->apellido)->first();

        if ($carrera) {
            return response()->json(['respuesta' => 'Esa persona ya existe']);
        }

        $carrera = new Carrera();
        $carrera->nombre = $request->nombre;
        $carrera->apellido=$request->apellido;
        $carrera->correo = $request->correo;
        $carrera->telefono = $request->telefono;
        $carrera->save();

        return response()->json(['respuesta' => $carrera->id]);
    }

    /**
     * Funcion para ver un tour individual
     * 
     * @param int $id - id del tour
     * 
     * @return Tour - informacion del Tour.
    */
    public function show(Persona $persona)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        //
    }
}
