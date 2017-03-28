<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rel_Estudio_Municipio extends Model
{
    protected $table ="rel_estudio_municipio";
    public $timestamps = false;

    public function detalle_municipios(){
    	return $this->hasMany('App\Cat_Municipio', 'id', 'id_municipio');
    }
}
