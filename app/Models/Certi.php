<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Certi extends Model
{
    protected $table = 'certi';

    protected $fillable = [
        'numero', 'fecha_extension', 'fecha_vencimiento', 'unidades_funcionales_existentes', 'unidades_funcionales_autorizadas', 
        'fecha_pago_licencia', 'no_licencia', 'no_expediente', 'nombre_propietario', 'direccion_inmueble', 'autorizacion_construccion',
        'area_construccion_autorizada', 'cantidad_niveles', 'codigo_inmueble', 'm_cuadrados_muro_perimetral', 'costo_obra',
        'tasa_alineacion', 'factura_tesoreria_licencia', 'factura_tesoreria_uso_suelo', 'factura_tesoreria_certificacion',
        'razonamiento_certificacion', 'autorizacion_uso_suelo', 'aprobada', 'id_paquete',
        'id_autorizacion_uso_certi', 'id_usiario_jefatura_valida', 'id_usuario_subio_certi'
    ];

    public function usuarios(){
        return $this->hasMany('App\User');
    }
}
