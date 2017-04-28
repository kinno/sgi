<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Anexo_Uno extends Model
{
    protected $table = "p_anexo_uno";

    protected $fillable = [
        'id_tipo_solicitud', 'id_sector', 'id_unidad_ejecutora', 'ejercicio', 'bevaluacion_socioeconomica', 'id_tipo_obra', 'id_modalidad_ejecucion','nombre_obra', 'justificacion_obra','principales_caracteristicas','bestudio_socioeconomico','bproyecto_ejecutivo','bderecho_via','bimpacto_ambiental','bobra','baccion','botro','descripcion_botro','monto','monto_municipal','fuente_municipal','id_meta','cantidad_meta','cantidad_beneficiario','id_beneficiario'
    ];


    public function setMontoAttribute($value)
    {
        $this->attributes['monto'] = str_replace(",", "", $value);
    }

    public function setMontoMunicipalAttribute($value)
    {
        $this->attributes['monto_municipal'] = ($value == "") ? null : str_replace(",", "", $value);
    }

    public function setCantidadMetaAttribute($value)
    {
        $this->attributes['cantidad_meta'] = str_replace(",", "", $value);
    }

    public function setCantidadBeneficiarioAttribute($value)
    {
        $this->attributes['cantidad_beneficiario'] = ($value == "") ? null : str_replace(",", "", $value);
    }

    public function setFechaCapturaAttribute()
    {
        $this->attributes['fecha_captura'] = date('Y-m-d H:i:s');
    }

    public function setIdUsuarioAttribute()
    {
        $this->attributes['id_usuario'] = \Auth::user()->id;
    }

    public function sector()
    {
        return $this->hasOne('App\Cat_Sector', 'id', 'id_sector');
    }

    public function unidad_ejecutora()
    {
        return $this->hasOne('App\Cat_Unidad_Ejecutora', 'id', 'id_unidad_ejecutora');
    }
}
