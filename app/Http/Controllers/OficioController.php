<?php

namespace App\Http\Controllers;

use App\Models\Oficio;
use App\Models\Empresa;
use App\Models\Estudiante;
use App\Models\Carrera;
use App\Models\Supervisor;
use Illuminate\Http\Request;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

class OficioController extends Controller
{
    private $roles_gate = '{"roles":[ 1, 2 ]}';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        Gate::authorize('haveaccess', $this->roles_gate );

        $empresa = Empresa::findOrFail($request->empresa_id);

        $estudiante = Estudiante::select('estudiante.*', 'persona.*', 'carrera.nombre as carrera', 'carrera.id as carrera_id');
        $estudiante = $estudiante->join('persona', 'persona_id', '=', 'persona.id');
        $estudiante = $estudiante->join('carrera', 'carrera_id', '=', 'carrera.id');
        $estudiante = $estudiante->join('users', 'persona.id', '=', 'users.persona_id');
        $estudiante = $estudiante->where('users.id',Auth::user()->id)->first();

        $oficio = new Oficio();
        $oficio->semestre = $request->semestre;
        $oficio->year = $request->year;
        $oficio->tipo = $request->tipo;
        $oficio->destinatario = $request->destinatario;
        $encabezado = (string)$request->encabezado;
        if($encabezado[-1] == ':'){ $encabezado = substr($encabezado, 0 , -1); }
        $oficio->encabezado = $encabezado;
        $oficio->empresa_id = $request->empresa_id;
        $oficio->usuario_id = Auth::user()->id;

        $est = (string)$estudiante->nombre . " " . (string)$estudiante->apellido;
        $oficio->estudiante = $est;
        $oficio->registro = $estudiante->registro;
        $oficio->carne = $estudiante->carne;

        $oficio->empresa = $empresa->nombre;
        $oficio->direccion = $empresa->direccion;
        $oficio->ubicacion = $empresa->ubicacion;

        if($request->tipo == 1){ // Práctica docente
            $oficio->curso = $request->curso;
            $oficio->codigo_curso = $request->codigo;
        }
        elseif($request->tipo == 2){ // Práctica investigación
            $tema = (string)$request->tema;
            if($tema[0] == '"'){ $tema = substr($tema, 1); }
            if($tema[-1] == '"'){ $tema = substr($tema, 0 , -1); }

            $oficio->curso = $tema;

        }
        else{ // Práctica aplicada 
            $oficio->puesto = $request->puesto;
        }        

        $oficio->save();

        return redirect()->route('practica.index');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Oficio  $oficio
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}' );
        
        $oficio = Oficio::findOrFail($id);

        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $oficio->usuario_id){abort(403);}
        }

        if($oficio->aprobado == 1){abort(403);}

        $punto ="";
        $ubicacion = (string)$oficio->ubicacion;
        if($ubicacion[-1] != '.'){ $punto = "."; }

        $datos = Carrera::select('carrera.nombre as carrera', 'carrera.id as carrera_id', 'estudiante.*');
        $datos = $datos->join('estudiante', 'carrera.id', '=','estudiante.carrera_id' );
        $datos = $datos->join('persona', 'estudiante.persona_id', '=', 'persona.id');
        $datos = $datos->join('users', 'persona.id', '=', 'users.persona_id');
        $datos = $datos->where('users.id', $oficio->usuario_id)->first();
    
        $carrera = $datos->carrera;
        $carrera_id = $datos->carrera_id;
        $id_sup = $datos->usuario_supervisor;
        
        $usr_sup = Supervisor::select('persona.*');
        $usr_sup = $usr_sup->join('persona', 'persona_id', '=', 'persona.id');
        $usr_sup = $usr_sup->join('users', 'persona.id', '=', 'users.persona_id');
        $usr_sup = $usr_sup->where('users.id', $id_sup)->first();

        $supervisor = "Ing. ".$usr_sup->nombre." ".$usr_sup->apellido;

        //Uso de fecha en espanol
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $date = Carbon::now();
        $mes = $meses[($date->format('n')) - 1];
        $fecha = $date->format('d') . ' de ' . $mes . ' de ' . $date->format('Y');

        $fecha_solicitud = null;
        //fecha solicitud
        if($oficio->f_solicitud){
            $date = Carbon::parse($oficio->f_solicitud);
            $mes = $meses[($date->format('n')) - 1];
            $fecha_solicitud = $date->format('d') . ' de ' . $mes . ' de ' . $date->format('Y');
        }

        //# de oficio
        $no_oficio = 'PF-';

        if($carrera_id == 1){$no_oficio .= 'IC No. ';}
        elseif($carrera_id == 2){$no_oficio .= 'IM No. '; $carrera="INGENIERÍA MECÁNICA";}
        elseif($carrera_id == 3){$no_oficio .= 'II No. ';}
        elseif($carrera_id == 4){$no_oficio .= 'IMI No. '; $carrera="INGENIERÍA MECÁNICA INDUSTRIAL";}
        elseif($carrera_id == 5 ){$no_oficio .= 'IS No. ';}

        $oficios_existentes = Oficio::select('oficio.*', 'carrera.id as carrera_id');
        $oficios_existentes = $oficios_existentes->join('users', 'oficio.usuario_id', '=', 'users.id');
        $oficios_existentes = $oficios_existentes->join('persona', 'users.persona_id', '=', 'persona.id');
        $oficios_existentes = $oficios_existentes->join('estudiante', 'persona.id', '=', 'estudiante.persona_id');
        $oficios_existentes = $oficios_existentes->join('carrera', 'estudiante.carrera_id', '=', 'carrera.id');
        $oficios_existentes =  $oficios_existentes->where('carrera.id', $carrera_id);
        $oficios_existentes =  $oficios_existentes->whereNotNull('oficio.no_oficio')->count();

        if($oficios_existentes<9){$no_oficio .= '00'; $no_oficio .= (string)($oficios_existentes+1);}
        else {$no_oficio .= '0'; $no_oficio .= (string)($oficios_existentes+1);}

        $year = date('yy');
        $no_oficio .= '-'.(string)$year ;

        return view('oficios.ver',compact(['oficio', 'punto', 'supervisor', 'carrera', 'no_oficio', 'fecha', 'fecha_solicitud']));    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Oficio  $oficio
     * @return \Illuminate\Http\Response
     */
    public function editar(Oficio $oficio)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Oficio  $oficio
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}' );

        $oficio = Oficio::findOrFail($request->id);
        $oficio->semestre = $request->semestre;
        $oficio->year = $request->year;
        $oficio->tipo = $request->tipo;
        $oficio->destinatario = $request->destinatario;
        $encabezado = (string)$request->encabezado;
        if($encabezado[-1] == ':'){ $encabezado = substr($encabezado, 0 , -1); }
        $oficio->encabezado = $encabezado;

        $oficio->empresa = $request->empresa;
        $oficio->direccion = $request->direccion;
        $oficio->ubicacion = $request->ubicacion;

        if($request->tipo == 1){ // Práctica docente
            $oficio->curso = $request->curso;
            $oficio->codigo_curso = $request->codigo;
            $oficio->f_solicitud = $request->fecha_docencia;
        }
        elseif($request->tipo == 2){ // Práctica investigación
            $tema = (string)$request->tema;
            if($tema[0] == '"'){ $tema = substr($tema, 1); }
            if($tema[-1] == '"'){ $tema = substr($tema, 0 , -1); }

            $oficio->curso = $tema;
            $oficio->f_solicitud = $request->fecha_investigacion;
        }
        else{ // Práctica aplicada 
            $oficio->puesto = $request->puesto;
            $oficio->cargo_encargado = $request->cargo_encargado;
        }        

        $oficio->save();

        return redirect()->route('oficio.ver', $oficio->id);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Oficio  $oficio
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Oficio $oficio)
    {
        //
    }

    public function validar(Request $request)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        
        $id = $request->id;
        $oficio = Oficio::findOrFail($id);
        $datos = Carrera::select('carrera.nombre as carrera', 'carrera.id as carrera_id', 'estudiante.*');
        $datos = $datos->join('estudiante', 'carrera.id', '=','estudiante.carrera_id' );
        $datos = $datos->join('persona', 'estudiante.persona_id', '=', 'persona.id');
        $datos = $datos->join('users', 'persona.id', '=', 'users.persona_id');
        $datos = $datos->where('users.id', $oficio->usuario_id)->first();
    
        $carrera_id = $datos->carrera_id;

        //# de oficio
        $no_oficio = 'PF-';

        if($carrera_id == 1){$no_oficio .= 'IC No. ';}
        elseif($carrera_id == 2){$no_oficio .= 'IM No. '; $carrera="INGENIERÍA MECÁNICA";}
        elseif($carrera_id == 3){$no_oficio .= 'II No. ';}
        elseif($carrera_id == 4){$no_oficio .= 'IMI No. '; $carrera="INGENIERÍA MECÁNICA INDUSTRIAL";}
        elseif($carrera_id == 5 ){$no_oficio .= 'IS No. ';}

        $oficios_existentes = Oficio::select('oficio.*', 'carrera.id as carrera_id');
        $oficios_existentes = $oficios_existentes->join('users', 'oficio.usuario_id', '=', 'users.id');
        $oficios_existentes = $oficios_existentes->join('persona', 'users.persona_id', '=', 'persona.id');
        $oficios_existentes = $oficios_existentes->join('estudiante', 'persona.id', '=', 'estudiante.persona_id');
        $oficios_existentes = $oficios_existentes->join('carrera', 'estudiante.carrera_id', '=', 'carrera.id');
        $oficios_existentes =  $oficios_existentes->where('carrera.id', $carrera_id);
        $oficios_existentes =  $oficios_existentes->whereNotNull('oficio.no_oficio')->count();

        if($oficios_existentes<9){$no_oficio .= '00'; $no_oficio .= (string)($oficios_existentes+1);}
        else {$no_oficio .= '0'; $no_oficio .= (string)($oficios_existentes+1);}

        $year = date('yy');
        $no_oficio .= '-'.(string)$year ;

        $oficio->no_oficio = $no_oficio;
        $oficio->f_oficio = Carbon::now();
        $oficio->aprobado = 1;
        $oficio->save();

        return redirect()->route('practica.index');  

    }

    public function pdf($id)
    {
        Gate::authorize('haveaccess', '{"roles":[ 1, 2, 3, 4, 5, 6, 7 ]}' );
       
        $oficio = Oficio::findOrFail($id);

        if(Auth::user()->rol->id == 2){        
            if(Auth::user()->id != $oficio->usuario_id){abort(403);}
        }

        $punto ="";
        $ubicacion = (string)$oficio->ubicacion;
        if($ubicacion[-1] != '.'){ $punto = "."; }

        $datos = Carrera::select('carrera.nombre as carrera', 'carrera.id as carrera_id', 'estudiante.*');
        $datos = $datos->join('estudiante', 'carrera.id', '=','estudiante.carrera_id' );
        $datos = $datos->join('persona', 'estudiante.persona_id', '=', 'persona.id');
        $datos = $datos->join('users', 'persona.id', '=', 'users.persona_id');
        $datos = $datos->where('users.id', $oficio->usuario_id)->first();
    
        $carrera = $datos->carrera;
        $carrera_id = $datos->carrera_id;
        $id_sup = $datos->usuario_supervisor;

        if($carrera_id == 2){$carrera="INGENIERÍA MECÁNICA";}
        elseif($carrera_id == 4){$carrera="INGENIERÍA MECÁNICA INDUSTRIAL";}
        
        $usr_sup = Supervisor::select('persona.*');
        $usr_sup = $usr_sup->join('persona', 'persona_id', '=', 'persona.id');
        $usr_sup = $usr_sup->join('users', 'persona.id', '=', 'users.persona_id');
        $usr_sup = $usr_sup->where('users.id', $id_sup)->first();

        $supervisor = "Ing. ".$usr_sup->nombre." ".$usr_sup->apellido;

        //Uso de fecha en espanol
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $date = Carbon::parse($oficio->f_oficio);
        $mes = $meses[($date->format('n')) - 1];
        $fecha = $date->format('d') . ' de ' . $mes . ' de ' . $date->format('Y');

        if($oficio->tipo == 1){

            $date = Carbon::parse($oficio->f_solicitud);
            $mes = $meses[($date->format('n')) - 1];
            $fecha_solicitud = $date->format('d') . ' de ' . $mes . ' de ' . $date->format('Y');

            $pdf = \PDF::loadView('pdf/docente', compact('oficio', 'punto', 'supervisor', 'carrera', 'fecha', 'fecha_solicitud'));
        }
        else if($oficio->tipo == 2){

            $date = Carbon::parse($oficio->f_solicitud);
            $mes = $meses[($date->format('n')) - 1];
            $fecha_solicitud = $date->format('d') . ' de ' . $mes . ' de ' . $date->format('Y');
            $pdf = \PDF::loadView('pdf/investigacion', compact('oficio', 'punto', 'supervisor', 'carrera', 'fecha', 'fecha_solicitud'));
        }
        else{
            $pdf = \PDF::loadView('pdf/aplicada', compact('oficio', 'punto', 'supervisor', 'carrera', 'fecha'));
        }       

        return $pdf->stream('archivo.pdf');

    }
}
