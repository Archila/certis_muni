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
        if($row[0]!="no_certi"){

            Config::set('global.paquete.cantidad', Config::get('global.paquete.cantidad')+1);
            
            return new Certi([
            'numero'  => $row[0],
            'fecha_extension'  => $row[1] ? date('Y-m-d', strtotime($row[1])) : '',
            'unidades_funcionales_existentes'  => $row[2] ? $row[2] : null,
            'unidades_funcionales_autorizadas'  => $row[3] ? $row[3] : null,
            'fecha_pago_licencia'  => $row[4] ? date('Y-m-d', strtotime($row[4])) : null,
            'no_licencia'  => $row[5] ? $row[5] : null,
            'no_expediente'  => $row[6] ? $row[6] : null,
            'nombre_propietario'  => $row[7] ? $row[7] : '',
            'direccion_inmueble'  => $row[8] ? $row[8] : '',
            'autorizacion_construccion'  => $row[9] ? $row[9] : '',
            'area_construccion_autorizada'  => $row[10] ? $row[10] : '',
            'cantidad_niveles'  => $row[11] ? $row[11] : null,
            'codigo_inmueble'  => $row[12] ? $row[12] : '',
            'm_cuadrados_muro_perimetral'  => $row[13] ? $row[13] : null,
            'costo_obra'  => $row[14] ? $row[14] : '',
            'tasa_alineacion'  => $row[15] ? $row[15] : '',
            'factura_tesoreria_licencia'  => $row[16] ? $row[16] : '',
            'factura_tesoreria_uso_suelo'  => $row[17] ? $row[17] : '',
            'factura_tesoreria_certificacion'  => $row[18] ? $row[18] : '',
            'razonamiento_certificacion'  => $row[19] ? $row[19] : '',
            'autorizacion_uso_suelo'  => $row[20] ? $row[20] : '',
            'id_usuario_subio_certi'  => Auth::user()->id,
            'id_paquete' => $this->id_paquete
        ]);
        }
    }
}
