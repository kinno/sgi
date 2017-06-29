<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class D_Contrato extends Model
{
    protected $table = 'd_contrato';

    public function adjudicacion(){
    	return $this->hasOne('App\Cat_Modalidad_Adjudicacion_Contrato','id','id_modalidad_adjudicacion_contrato');
    }

    public function tipo_contrato(){
    	return $this->hasOne('App\Cat_Tipo_Contrato','id','id_tipo_contrato');
    }

    public function tipo_obra_contrato(){
    	return $this->hasOne('App\Cat_Tipo_Obra_Contrato','id','id_tipo_obra_contrato');
    }
}
