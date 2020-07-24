<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Folio;

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
}
