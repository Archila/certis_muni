<?php

namespace App\Imports;

use App\Models\Certi;
use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Facades\Auth;
use Config;

class CertiImport implements ToModel
{

    public function  __construct($id_paquete)
    {
        $this->id_paquete= $id_paquete;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(trim($row[0])!="no_certi" || trim($row[0])!="NO_CERTI_UNIQUE"){

            Config::set('global.paquete.cantidad', Config::get('global.paquete.cantidad')+1);
            $fecha_string = str_replace('/','-',$row[13]);
            $fecha_ext = $row[13] ? date('Y-m-d', strtotime($fecha_string)) : null;
            
            return new Certi([
            'numero'  => $row[0],
            'no_expediente'  => $row[1] ? $row[1] : null,
            'nombre_propietario'  => $row[2] ? $row[2] : '',
            'direccion_inmueble'  => $row[3] ? $row[3] : '',
            'zona'  => $row[4] ? $row[4] : null,
            'destino_autorizado'  => $row[5] ? $row[5] : null,
            'cantidad_niveles'  => $row[6] ? $row[6] : null,
            'unidades_funcionales_existentes'  => $row[7] ? $row[7] : null,
            'unidades_funcionales_autorizadas'  => $row[8] ? $row[8] : null,
            'area_construccion_autorizada'  => $row[9] ? $row[9] : '',
            'costo_obra'  => $row[10] ? $row[10] : '',
            'no_licencia'  => $row[11] ? $row[11] : null,
            'razonamiento'  => $row[12] ? $row[12] : null,
            'razonamiento'  => $row[12] ? $row[12] : null,
            'codigo_inmueble'  => $row[14] ? $row[14] : null,
            'fecha_extension'  => $fecha_ext,
            'fecha_vencimiento'  => $fecha_ext ? date('Y-m-d', strtotime("+1 months", strtotime($fecha_ext))) : null,
            'id_usuario_subio_certi'  => Auth::user()->id,
            'id_paquete' => $this->id_paquete
        ]);
        }
    }
}
