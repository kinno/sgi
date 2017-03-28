<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rel_Estudio_Region extends Model
{
    protected $table = "rel_estudio_region";
    public $timestamps = false;

    public function detalle_regiones(){
    	return $this->hasMany('App\Cat_Region', 'id', 'id_region');
    }
}
