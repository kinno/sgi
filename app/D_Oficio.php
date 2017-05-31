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
}
