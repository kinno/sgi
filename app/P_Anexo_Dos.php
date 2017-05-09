<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Anexo_Dos extends Model
{
     protected $table = "p_anexo_dos";

     public function cobertura(){
     	return $this->hasOne('App\Cat_Cobertura','id','id_cobertura');
     }

     public function localidad(){
     	return $this->hasOne('App\Cat_Tipo_Localidad','id','id_tipo_localidad');
     }
}
