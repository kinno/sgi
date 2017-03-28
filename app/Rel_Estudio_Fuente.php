<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rel_Estudio_Fuente extends Model
{
    protected $table = "rel_estudio_fuente";

    public function detalle_fuentes(){
    	return $this->hasMany('App\Cat_Fuente','id','id_fuente');
    }
}
