<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class P_Estudio_Socioeconomico extends Model
{
    protected $table   = "p_estudio_socioeconomico";

    public function getFechaRegistroAttribute($value){
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getFechaIngresoAttribute($value){
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function hoja1()
    {
        return $this->hasOne('App\P_Anexo_Uno_Estudiosocioeconomico', 'id', 'id_anexo_uno_estudio');
    }

    public function hoja2()
    {
        return $this->hasOne('App\P_Anexo_Dos_Estudiosocioeconomico', 'id', 'id_anexo_dos_estudio');
    }

    public function acuerdos()
    {
        return $this->belongsToMany('App\Cat_Acuerdo','rel_estudio_acuerdo','id_estudio_socioeconomico','id_acuerdo');
        // return $this->hasMany('App\Rel_Estudio_Acuerdo', 'id_estudio_socioeconomico', 'id');
    }

    public function fuentes_monto()
    {
        return $this->belongsToMany('App\Cat_Fuente','rel_estudio_fuente','id_estudio_socioeconomico', 'id_fuente')->withPivot('monto', 'tipo_fuente')->withTimestamps();
        // return $this->hasMany('App\Rel_Estudio_Fuente', 'id_estudio_socioeconomico', 'id');
    }

    public function regiones()
    {
        return $this->belongsToMany('App\Cat_Region', 'rel_estudio_region', 'id_estudio_socioeconomico', 'id_region');
        // return $this->hasMany('App\Rel_Estudio_Region', 'id_estudio_socioeconomico', 'id');
    }

    public function municipios()
    {   
        return $this->belongsToMany('App\Cat_Municipio', 'rel_estudio_municipio', 'id_estudio_socioeconomico', 'id_municipio');
        // return $this->hasMany('App\Rel_Estudio_Municipio', 'id_estudio_socioeconomico', 'id');
    }

    public function movimientos(){
        return $this->hasMany('App\P_Movimiento_Banco','id_estudio_socioeconomico','id');
    }

    public function indicadores(){
        return $this->hasMany('App\P_Indicadores_Rentabilidad','id_estudio_socioeconomico','id');
    }
    
}
