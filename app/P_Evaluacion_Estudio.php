<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Evaluacion_Estudio extends Model
{
    protected $table = "p_evaluacion_estudio";

    public function sub_inciso(){
    	return $this->hasOne('App\Cat_Subinciso','id','id_sub_indice');
    }
}
