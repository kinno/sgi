<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Contrato extends Model
{
   protected $table = 'p_contrato';

   public function d_contrato(){
   	return $this->hasOne('App\D_Contrato','id_contrato','id');
   }

   public function empresa(){
   	return $this->hasOne('App\Cat_Empresa','id','id_empresa');
   }

   public function avance_financiero(){
   	return $this->hasOne('App\P_Avance_Financiero_Contrato','id_contrato','id');
   }

   public function avance_fisico(){
      return $this->hasMany('App\P_Programa_Contrato','id_contrato','id');
   }

   public function conceptos(){
      return $this->hasMany('App\P_Presupuesto_Obra','id_contrato','id');
   }
}
