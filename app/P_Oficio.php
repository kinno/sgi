<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Oficio extends Model
{
    protected $table="p_oficio";

    public function detalle(){
    	return $this->hasMany('App\D_Oficio','id_oficio','id');
    }

    public function tipo_solicitud(){
    	return $this->hasOne('App\Cat_Solicitud_Presupuesto','id','id_solicitud_presupuesto');
    }

    public function frase_ejercicio(){
    	return $this->hasOne('App\Cat_Ejercicio','ejercicio','ejercicio');
    }

    public function sector(){
        return $this->hasOne('App\Cat_Sector','id','id_sector');
    }

    
}
