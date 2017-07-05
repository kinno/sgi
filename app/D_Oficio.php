<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class D_Oficio extends Model
{
    protected $table = "d_oficio";

    public function fuentes(){
    	return $this->hasOne('App\Cat_Fuente','id','id_fuente');
    }

    public function principal_oficio(){
    	return $this->belongsTo('App\P_Oficio','id_oficio','id');
    }

    public function obras(){
    	return $this->hasOne('App\D_Obra','id','id_det_obra');
    }

    public function unidad_ejecutora(){
        return $this->hasOne('App\Cat_Unidad_Ejecutora','id','id_unidad_ejecutora');
    }

    public function oficio(){
         return $this->hasOne('App\P_Oficio','id','id_oficio');
    }

    public function tipo_solicitud(){
        return $this->hasOne('App\Cat_Solicitud_Presupuesto','id','id_solicitud_presupuesto');
    }

}
