<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Folio;
use App\Models\Persona;
use App\Models\Encargado;
use App\Models\Area;
use App\Models\AreaEncargado;
use App\Models\Empresa;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;


class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function folios_revisar(Request $request)
    {
        //Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $bitacora = Bitacora::findOrFail($request->bitacora_id);

        $folios = Folio::select('folio.*');
        $folios = $folios->where('bitacora_id',$bitacora->id);
        $folios = $folios->where('revisado', 0);
        $folios = $folios->whereBetween('numero', [$request->folio_inicial, $request->folio_final]);
        $folios = $folios->orderBy('numero')->get();

        $msg = '';

        foreach ($folios as $f){
            $msg .= '<tr>' 
                        .'<td>'
                        .'<div class="row">'
                        .'<p class="col-sm-12"><b>Folio: </b>'.$f->numero.'</p>'
                        .'<p class="col-sm-12"><b>Horas: </b>'.$f->horas.'</p>'
                        .'<p class="col-sm-12"><b>Fecha inicial: </b>'.date('d-m-Y', strtotime($f->fecha_inicial)).'</p>'
                        .'<p class="col-sm-12"><b>Fecha final: </b>'.date('d-m-Y', strtotime($f->fecha_final)).'</p>'
                        .'</div>'
                        .'</td>'
                        .'<td style="font-size: 0.85em;">'.$f->descripcion.'</td>'
                        .'<td style="font-size: 0.85em;">'.$f->observaciones.'</td>'
                        .'</tr>';
        }
        
        return response()->json(['success'=>true, 'msg'=>$msg]);
    }

    public function empresas(Request $request)
    {
        //Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $empresas = Empresa::where('empresa.nombre','like','%'.$request->buscador.'%');
        $empresas = $empresas->orderBy('nombre','asc')->get();

        $msg = '';
        foreach ($empresas as $e){
            $msg .= '<option value="'.$e->id.'">'.$e->nombre.'</option>';
        }
        
        return response()->json(['success'=>true, 'msg'=>$msg, 'empresas'=>$empresas]);
    }


    public function areas_empresa(Request $request)
    {
        //Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $areas = Area::where('area.empresa_id',$request->empresa_id);
        $areas = $areas->orderBy('created_at','desc')->get();

        $msg = '';
        foreach ($areas as $a){
            $msg .= '<option value="'.$a->id.'">'.$a->nombre.'</option>';
        }
        
        return response()->json(['success'=>true, 'msg'=>$msg, 'areas'=>$areas]);
    }

    public function encargados_area(Request $request)
    {   
        //Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $areasEncargado = AreaEncargado::select('area_encargado.*', 'encargado.*', 'persona.*', 'encargado.id as encargado_id');
        $areasEncargado = $areasEncargado->join('encargado', 'area_encargado.encargado_id', '=', 'encargado.id');
        $areasEncargado = $areasEncargado->join('persona', 'encargado.persona_id', '=', 'persona.id');
        $areasEncargado = $areasEncargado->where('area_encargado.area_id',$request->area_id)->get();

        
        $msg = '';
        if($areasEncargado->count()>=1){            
            foreach($areasEncargado as $a){
                $msg .= '<option value="'.$a->encargado_id.'">'.$a->nombre.' '.$a->apellido.' -- '.$a->puesto.'</option>';
            }       
        }
        else{
            $msg .= '<option disabled>Seleccione un encargado</option>';         
        }
        
        return response()->json(['success'=>true, 'msg'=>$msg]);
    }

    public function encargados(Request $request)
    {   
        //Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $encargados = Encargado::select('encargado.*', 'persona.*', 'encargado.id as encargado_id');
        $encargados = $encargados->join('persona', 'persona_id', '=','persona.id');
        $encargados = $encargados->orderBy('encargado.created_at','desc')->get();

        
        $msg = '';
        if($encargados->count()>=1){              
            foreach($encargados as $e){
                $msg .= '<option value="'.$e->encargado_id.'">'.$e->nombre.' '.$e->apellido.'</option>';
            }       
        }
        else{
            $msg .= '<option disabled>No hay encargados, por favor cree uno.</option>';         
        }
        
        return response()->json(['success'=>true, 'msg'=>$msg]);
    }

    public function crear_area(Request $request)
    {
        //Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $area = new Area();
        $area->nombre = $request->nombre;
        $area->descripcion = $request->descripcion;
        $area->empresa_id = $request->empresa_id;
        $area->save();
        
        return response()->json(['success'=>true, 'msg'=>$area]);
    }

    public function crear_encargado(Request $request)
    {
        //Gate::authorize('haveaccess', '{"roles":[ 1, 3, 4, 5, 6, 7 ]}' );
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->telefono = $request->telefono;
        $persona->correo = $request->correo;
        $persona->save();

        $encargado = new Encargado();
        $encargado->colegiado = $request->colegiado;
        $encargado->profesion = $request->profesion;
        $encargado->persona_id = $persona->id;
        $encargado->usuario_id = Auth::user()->id;
        $encargado->save();

        $msg ='';
        
        return response()->json(['success'=>true, 'msg'=>$msg]);
    }

}
