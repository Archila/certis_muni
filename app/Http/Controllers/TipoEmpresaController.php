<?php

namespace App\Http\Controllers;

use App\Models\TipoEmpresa;
use Illuminate\Http\Request;

class TipoEmpresaController extends Controller
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
            'activo' => 'nullable|string',
        ]);
  
        $many = 5;
        if($request->has('many')) $many = $request->many;
  
        $sort_by = 'tipo_empresa.created_at';
        if($request->has('sort_by')) $sort_by = 'tipo_empresa.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $tipos = TipoEmpresa::orderBy($sort_by, $direction);
  
        if ($request->has('nombre')) {
          $tipos->orWhere('nombre', 'LIKE', '%' . $request->nombre . '%');
        }
  
        if ($request->has('activo')) {
          $tipos->orWhere('activo', $request->activo);
        }
  
        if ($request->has('many')) {
          $tipos = $tipos->orderBy($sort_by, $direction)->paginate($many);          
        }
        else {
          $tipos = $tipos->orderBy($sort_by, $direction)->get();
        }
  
        //return response()->json($carreras);
        return view('tipo_empresas.index',compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('tipo_empresas.crear');
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
        
        $tipo = TipoEmpresa::where('nombre', '=',$request->nombre)->first();

        if ($tipo) {            
            return redirect()->route('tipo_empresa.crear')->with('error', 'ERROR');             
        }

        $tipo = new TipoEmpresa();
        $tipo->nombre = $request->nombre;
        $tipo->descripcion = $request->descripcion;
        $tipo->save();

        return redirect()->route('tipo_empresa.index')->with('creado', $tipo->id);      

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoEmpresa  $tipoEmpresa
     * @return \Illuminate\Http\Response
     */
    public function ver(TipoEmpresa $tipoEmpresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoEmpresa  $tipoEmpresa
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        $tipo = TipoEmpresa::findOrFail($id);
        return view('tipo_empresas.editar', compact('tipo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoEmpresa  $tipoEmpresa
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, TipoEmpresa $tipoEmpresa)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $tipo = TipoEmpresa::where('nombre',$request->nombre);

        if ($tipo) {            
            return redirect()->route('tipo_empresa.editar', $request->id)->with('error','ERROR');             
        } 

        $tipo = TipoEmpresa::findOrFail($request->id);        

        $tipo->nombre = $request->nombre;
        $tipo->descripcion = $request->descripcion; 
        if($request->activo){
            $activo=1;
        }
        else { $activo=0;}
        $tipo->activo = $activo;         
        $condicion = $tipo->save();

        //return response()->json(['respuesta' => $condicion]);
        return redirect()->route('tipo_empresa.index')->with('editado', $condicion); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoEmpresa  $tipoEmpresa
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request)
    {
        $tipo = TipoEmpresa::findOrFail($request->id);
        $tipo = $tipo->delete();

        //return dd($request->id);
        return redirect()->route('tipo_empresa.index')->with('eliminado', true); 
    }
}
