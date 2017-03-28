<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Indicadores_Rentabilidad extends Model
{
    protected $table = "p_indicadores_rentabilidad";

    public function evaluaciones(){
    	return $this->hasMany('App\P_Evaluacion_Estudio','id_evaluacion_estudio','id_evaluacion');
    }

    public function tipo_ppi(){
    	return $this->hasOne('App\Cat_Ppi','id','id_tipo_ppi');
    }
}
