<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Obra extends Model
{
    protected $table = "p_obra";
    public $timestamps = false;

    public function detalle(){
    	return $this->hasMany('App\D_Obra','id_obra','id');
    }
}
