<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\TipoEmpresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
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
  
        $sort_by = 'empresa.created_at';
        if($request->has('sort_by')) $sort_by = 'empresa.'.$request->sort_by;
  
        $direction = 'desc';
        if($request->has('direction')) $direction = $request->direction;
  
        $empresas = Empresa::select('empresa.*', 'tipo_empresa.nombre as tipo', 'empresa.id as empresa_id');

        $empresas ->join('tipo_empresa', 'tipo_empresa_id', '=', 'tipo_empresa.id');
  
        if ($request->has('nombre')) {
          $empresas->orWhere('nombre', 'LIKE', '%' . $request->nombre . '%');
        }  

        if ($request->has('alias')) {
            $empresas->orWhere('alias', 'LIKE', '%' . $request->alias . '%');
        }  

        if ($request->has('carne')) {
            $empresas->orWhere('carne', 'LIKE', '%' . $request->carne . '%');
        }  

        if ($request->has('registro')) {
            $empresas->orWhere('registro', 'LIKE', '%' . $request->registro . '%');
        }  

        if ($request->has('carrera_id')) {
            $empresas->orWhere('carrera_id', $request->carrera_id);
        }  
         
        if ($request->has('many')) {
          $empresas = $empresas->orderBy($sort_by, $direction)->paginate($many);          
        }
        else {
          $empresas = $empresas->orderBy($sort_by, $direction)->get();
        }
  
        //return response()->json($carreras);
        return view('empresas.index',compact('empresas'));
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
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
