<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;

use Carbon\Carbon;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class SolicitudController extends Controller
{
    private $roles_gate = '{"roles":[ 1, 2, 3, 4, 5, 5, 7 ]}';

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
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {
       
    }   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request)
    {
        
    }

    public function actualizar_requisito(Request $request)
    {
        //1 - Constancia de inscripción
        //2 - Certificación de cursos
        //3 - Cronograma de actividades
        //4 - Carta de solicitud y compromiso
        $request->validate([
            'file' => 'required|mimes:pdf,PDF|max:2048',
        ]);

        $path = Storage::put('public', $request->file);        
        
        $solicitud = Solicitud::all();
        $solicitud = $solicitud->where('usuario_id',Auth::user()->id)->first();

        if(empty($solicitud)){
            $nueva_solicitud = new Solicitud();
            $nueva_solicitud->saludo = " ";
            $nueva_solicitud->usuario_id = Auth::user()->id;
            $nueva_solicitud->save();

            $solicitud = Solicitud::all();
            $solicitud = $solicitud->where('usuario_id',Auth::user()->id)->first();
        } 

        switch ($request->tipo) {
            case 1:
                if(!empty($solicitud->ruta_constancia)) {Storage::delete($solicitud->ruta_constancia);}
                $solicitud->ruta_constancia = $path;
                $solicitud->save();
                break;
            
            case 2:
                if(!empty($solicitud->ruta_certificacion)) {Storage::delete($solicitud->ruta_certificacion);}
                $solicitud->ruta_certificacion = $path;
                $solicitud->save();
                break;

            case 3:
                if(!empty($solicitud->ruta_cronograma)) {Storage::delete($solicitud->ruta_cronograma);}
                $solicitud->ruta_cronograma = $path;
                $solicitud->save();
                break;

            case 4:
                if(!empty($solicitud->ruta_carta)) {Storage::delete($solicitud->ruta_carta);}
                $solicitud->ruta_carta = $path;
                $solicitud->save();
                break;
            
            default:
                # code...
                break;
        }
        return redirect()->route('practica.index');
    }

}
