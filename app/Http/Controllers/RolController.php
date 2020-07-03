<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
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
        $request->validate([
            'all' => 'nullable|boolean',
            'many' => 'nullable|integer',
            'sort_by' => 'nullable|string',
            'direction' => 'nullable|string',
            'nombre' => 'nullable|string',
        ]);
  
        $many = 5;
        if($request->has('many')) $many = $request->many;
  
        $sort_by = 'rol.created_at';
        if($request->has('sort_by')) $sort_by = 'rol.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $roles = Rol::orderBy($sort_by, $direction);
  
        if ($request->has('nombre')) {
          $roles->orWhere('nombre', 'LIKE', '%' . $request->nombre . '%');
        }
  
        if ($request->has('many')) {
          $roles = $roles->orderBy($sort_by, $direction)->paginate($many);          
        }
        else {
          $roles = $roles->orderBy($sort_by, $direction)->get();
        }
  
        //return response()->json($carreras);
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('roles.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $rol = Rol::where('nombre', '=',$request->nombre)->first();

        if ($rol) {            
            return redirect()->route('rol.crear')->with('error', 'ERROR');             
        }

        $rol = new Rol();
        $rol->nombre = $request->nombre;
        $rol->descripcion = $request->descripcion;
        $rol->save();

        return redirect()->route('rol.index')->with('creado', $rol->id);        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function ver(Rol $rol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        $rol = Rol::findOrFail($id);
        return view('roles.editar', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $rol = Rol::where('id','!=',$request->id)->where('nombre',$request->nombre)->get();

        if (count($rol)>0) {            
            return redirect()->route('rol.editar', $request->id)->with('error','ERROR');             
        } 

        $rol = Rol::findOrFail($request->id);

        $rol->nombre = $request->nombre;
        $rol->descripcion = $request->descripcion;
        $condicion = $rol->save();

        return redirect()->route('rol.index')->with('editado', $condicion);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request)
    {
        $rol = Rol::findOrFail($request->id);
        $condicion = $rol->delete();

        //return dd($request->id);
        return redirect()->route('rol.index')->with('eliminado', true); 
    }
}
