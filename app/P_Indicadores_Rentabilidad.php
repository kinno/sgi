<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class P_Indicadores_Rentabilidad extends Model
{
    protected $table = "p_indicadores_rentabilidad";

    public function getFechaAttribute($value){
    	return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function evaluaciones(){
    	return $this->hasMany('App\P_Evaluacion_Estudio','id_evaluacion_estudio','id_evaluacion');
    }

    public function tipo_ppi(){
    	return $this->hasOne('App\Cat_Ppi','id','id_tipo_ppi');
    }
}
