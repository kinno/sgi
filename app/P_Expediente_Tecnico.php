<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class P_Expediente_Tecnico extends Model
{
    protected $table = "p_expediente_tecnico";

    public function getFechaEnvioAttribute($value){
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function tipoSolicitud(){
    	return $this->hasOne('App\Cat_Solicitud_Presupuesto','id','id_tipo_solicitud');
    }

     public function hoja1()
    {
        return $this->hasOne('App\P_Anexo_Uno', 'id', 'id_anexo_uno');
    }

    public function hoja2()
    {
        return $this->hasOne('App\P_Anexo_Dos', 'id', 'id_anexo_dos');
    }
    

     public function acuerdos()
    {
        return $this->belongsToMany('App\Cat_Acuerdo','rel_expediente_acuerdo','id_expediente_tecnico','id_acuerdo');
        // return $this->hasMany('App\Rel_Estudio_Acuerdo', 'id_estudio_socioeconomico', 'id');
    }

    public function fuentes_monto()
    {
        return $this->belongsToMany('App\Cat_Fuente','rel_expediente_fuente','id_expediente_tecnico', 'id_fuente')->withPivot('monto', 'tipo_fuente')->withTimestamps();
        // return $this->hasMany('App\Rel_Estudio_Fuente', 'id_estudio_socioeconomico', 'id');
    }

    public function regiones()
    {
        return $this->belongsToMany('App\Cat_Region', 'rel_expediente_region', 'id_expediente_tecnico', 'id_region');
        // return $this->hasMany('App\Rel_Estudio_Region', 'id_estudio_socioeconomico', 'id');
    }

    public function municipios()
    {   
        return $this->belongsToMany('App\Cat_Municipio', 'rel_expediente_municipio', 'id_expediente_tecnico', 'id_municipio');
        // return $this->hasMany('App\Rel_Estudio_Municipio', 'id_estudio_socioeconomico', 'id');
    }

    public function conceptos(){
        return $this->hasMany('App\P_Presupuesto_Obra','id_expediente_tecnico','id');
    }

    public function relacion()
    {
        return $this->hasOne('App\Rel_Estudio_Expediente_Obra', 'id_expediente_tecnico', 'id');
    }

    public function programas(){
        return $this->hasMany('App\P_Programa','id_expediente_tecnico','id');
    }

    public function avance_financiero(){
        return $this->hasOne('App\P_Avance_Financiero','id_expediente_tecnico','id');
    }

    public function hoja5(){
        return $this->hasOne('App\P_Anexo_Cinco','id','id_anexo_cinco');
    }

    public function hoja6(){
        return $this->hasOne('App\P_Anexo_Seis','id','id_anexo_seis');
    }

    public function observaciones(){
        return $this->hasMany('App\P_Evaluacion_Expediente','id_expediente_tecnico','id');
    }

}
