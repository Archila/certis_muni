<?php

namespace App\Http\Controllers;

use App\Models\Folio;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use App\Models\Certi;
use App\Models\Paquete;
use App\Models\Aprobacion;
use App\Imports\CertiImport;

use Maatwebsite\Excel\Files\ExcelFile;

use Maatwebsite\Excel\Facades\Excel;
use Config;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

class CertiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function subir_archivo(Request $request)
    {   
        try {
            DB::beginTransaction();
            $paquete = new Paquete();
            $paquete->fecha = $request->fecha;
            $paquete->observaciones = $request->observaciones;
            $paquete->cantidad = 0;
            $paquete->usuario_realiza = Auth::user()->id;
            $paquete->save();

            Config::set('global.paquete.id', $paquete->id);
            Config::set('global.paquete.cantidad', 0);
            Excel::import(new CertiImport($paquete->id), request()->file('file'));
            $paquete->cantidad = Config::get('global.paquete.cantidad');
            $paquete->save();
            // database queries here
            DB::commit();
            return redirect()->route('inicio.index'); 
        } catch (\PDOException $e) {
            // Woopsy
            DB::rollBack();

            //return $e;
            return redirect()->route('inicio.index', ['error' => $e->errorInfo]); 
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {

        $data = (object) [];
        $data->licencia = null;
        $data->expediente = null;
        $data->propietario = null;
        $data->numero = null;
        $data->inmueble = null;

        $pagina = 0;
        if($request->has('page')) $data->pagina = $request->page;
        else $data->pagina = 1;
        $tabla =[];

        $paquete = Paquete::findOrFail($id);

        $tabla = Certi::select('*');
        if ($request->has('licencia') && trim($request->licencia)!= '') {
            $tabla->where('no_licencia', 'like', '%' . $request->licencia . '%');
            $data->licencia = $request->licencia;
        }
        if ($request->has('expediente') && trim($request->expediente)!= '') {
            $tabla->where('no_expediente', 'like', '%' . $request->expediente . '%');
            $data->expediente = $request->expediente;
        }
        if ($request->has('propietario') && trim($request->propietario)!= '') {
            $tabla->where('nombre_propietario', 'like', '%' . $request->propietario . '%');
            $data->propietario = $request->propietario;
        }
        if ($request->has('numero') && trim($request->numero)!= '') {
            $tabla->where('numero', 'like', '%' . $request->numero . '%');
            $data->numero = $request->numero;
        }
        if ($request->has('inmueble') && trim($request->inmueble)!= '') {
            $tabla->where('codigo_inmueble', 'like', '%' . $request->inmueble . '%');
            $data->inmueble = $request->inmueble;
        }
        $tabla = $tabla->where('id_paquete','=', $id);
        if(Auth::user()->rol->id == 3) {
            $tabla = $tabla->where('estado','=', 1);
        }
        $tabla = $tabla->paginate(15);
        return view('inicio.certificacion',compact(['data','tabla', 'paquete'])); 
    }

    public function ver($id, Request $request)
    {

        $certi = Certi::select('certi.*');
        //$certi ->join('persona', 'persona_id', '=', 'persona.id');

        $certi = $certi->where('certi.id','=',$id);

        $certi = $certi->get()->first();

        $user = Auth::user();

        $paquete = Paquete::select('certi.id');
        $paquete = $paquete->join('certi', 'certi.id_paquete', 'paquete.id');
        $certi_min= $paquete->min('certi.id');
        $certi_max= $paquete->max('certi.id');

        return view('inicio.ver', compact(['certi', 'user', 'certi_min', 'certi_max']));

    }

    public function aprobar(Request $request)
    {

        $certi = Certi::findOrFail($request->id);
        $certi->estado = 1;
        $certi->save();

        $aprobada = new Aprobacion();
        $aprobada->fecha = Carbon::now();
        $aprobada->observaciones = $request->observaciones;
        $aprobada->id_certi = $request->id;
        $aprobada->id_usuario = Auth::user()->id;
        $aprobada->save();


        return redirect()->route('certi.ver', $certi->id); 

    }

    public function rechazar(Request $request)
    {

        $certi = Certi::findOrFail($request->id);
        $certi->estado = 2;
        $certi->numero = null;
        $certi->save();

        return redirect()->route('certi.ver', $certi->id); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        //
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
     * @param  \App\Models\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function show(Folio $folio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {   
        $folio = Folio::findOrFail($id);
        if($folio->revisado){ abort(403);}

        $bitacora = Bitacora::findOrFail($folio->bitacora_id);

        $folios = Folio::select('folio.*');
        $folios = $folios->where('bitacora_id',$bitacora->id);
        $folios = $folios->orderBy('numero')->get();

        return view('folios.editar', compact(['bitacora','folio', 'folios']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, $id)
    {
        $folio = Folio::findOrFail($id);

        $horas_anterior = $folio->horas;

        $folio->numero = $request->numero;
        $folio->fecha_inicial = $request->fecha_inicial;
        $folio->fecha_final = $request->fecha_final;
        $folio->horas = $request->horas;
        $folio->descripcion = $request->descripcion;
        $folio->observaciones = $request->observaciones;
        $folio->save();

        $bitacora = Bitacora::findOrFail($folio->bitacora_id);
        $horas = Folio::where('bitacora_id',$bitacora->id)->sum('horas');
        $bitacora->horas = $horas;
        $bitacora->save();
        
        return redirect()->route('bitacora.ver', $bitacora->id)->with('editado', $folio->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folio $folio)
    {
           
    }

    
}
