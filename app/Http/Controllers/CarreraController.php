<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    /**
     * Función que devuelve las carreras
     *
     * Parámetros opcionales:
     * @param boolean $all - Valor para devolver la lista sin paginación
     * @param int $many - Cantidad de objetos por página
     * @param string $sort_by - Columna por la que se va a ordenar
     * @param string $direction - Dirección del orden
     * @param string $nombre - Nombre de la carrera
     * @param string codigo - Codigo de la carrera
     *
     * @return array $carreras - Lista de las carreras
    */
    public function index(Request $request)
    {
      $request->validate([
          'all' => 'nullable|boolean',
          'many' => 'nullable|integer',
          'sort_by' => 'nullable|string',
          'direction' => 'nullable|string',
          'nombre' => 'nullable|string',
          'codigo' => 'nullable|string',
      ]);

      $many = 5;
      if($request->has('many')) $many = $request->many;

      $sort_by = 'carrera.created_at';
      if($request->has('sort_by')) $sort_by = 'carrera.'.$request->sort_by;

      $direction = 'desc';
      if($request->has('direction')) $direction = $request->direction;

      $carreras = Carrera::orderBy($sort_by, $direction);

      if ($request->has('nombre')) {
        $carreras->orWhere('nombre', 'LIKE', '%' . $request->nombre . '%');
      }

      if ($request->has('codigo')) {
        $carreras->orWhere('codigo', 'LIKE', '%' . $request->codigo . '%');
      }

      if ($request->has('many')) {
        $carreras = $carreras->orderBy($sort_by, $direction)->paginate($many);          
      }
      else {
        $carreras = $carreras->orderBy($sort_by, $direction)->get();
      }

      //return response()->json($carreras);
      return view('carreras.index',compact('carreras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function crear()
    {
        return view('carreras.crear');
    }

    /**
     * Función para agregar una carrera
     *
     * Parámetros requeridos:
     * @param string $nombre - El nombre que se le va a asignar a la carrera
     * @param string $nombre - El codigo que se le va a asignar a la carrera
     *
     * @return int $id - Id de la carrera guardada
    */
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string',
            'prefijo' => 'required|string',
        ]);

        $carrera = Carrera::where('codigo', '=',$request->codigo)->first();

        if ($carrera) {            
            return redirect()->route('carrera.crear')->with('error', 'ERROR');             
        }

        $carrera = new Carrera();
        $carrera->nombre = $request->nombre;
        $carrera->codigo = $request->codigo;
        $carrera->prefijo = $request->prefijo;
        $carrera->save();

        return redirect()->route('carrera.index')->with('creado', $carrera->id);        
    }

    /**
     * Funcion para ver una carrera individual
     *
     * @param int $id - id de la carrera
     *
     * @return Carrera - informacion de la carrera.
    */
    public function ver(Request $request)
    {
        //Comprobamos que la carrera exista
        $carrera = Carrera::findOrFail($request->id);
        //$estudiantes = Carrera::findOrFail($request->id)->estudiantes;

        //return response()->json(['carrera' => $carrera, 'estudiantes'=> $estudiantes]);
        //return response()->json(['carrera' => $carrera]);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {   
        $carrera = Carrera::findOrFail($id);
        return view('carreras.editar', compact('carrera'));
    }

    /**
     * Función para editar una carrera
     * 
     * Parámetros requeridos:
     * @param int $id - Id del pais que se va a modificar
     * @param string $nombre - El nuevo nombre del pais
     * 
     * @return boolean $respuesta - Confirma si se realizó el cambio
    */
    public function actualizar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string',
            'prefijo' => 'required|string',
        ]);

        $carrera = Carrera::findOrFail($request->id);
        
        $carrera->nombre = $request->nombre;
        $carrera->codigo = $request->codigo;    
        $carrera->prefijo = $request->prefijo;        
        $condicion = $carrera->save();

        //return response()->json(['respuesta' => $condicion]);
        return redirect()->route('carrera.index')->with('editado', $condicion);  
    }

    /**
     * Función para borrar una carrera
     * 
     * Parámetros requeridos:
     * @param int $id - Id de la carrera que se va a eliminar
     * 
     * @return boolean $respuesta - Confirma si se eliminó la carrera
    */
    public function eliminar(Request $request)
    {
        $carrera = Carrera::findOrFail($request->id);
        $condicion = $carrera->delete();

        //return dd($request->id);
        return redirect()->route('carrera.index')->with('eliminado', true); 
    }
}
