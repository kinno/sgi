<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Punto extends Model
{
    protected $table = "cat_punto";
    public $timestamps = false;

    public function inciso(){
    	return $this->hasMany('App\Cat_Inciso','id_punto','id');
    }

    // public function subinciso(){
    // 	return $this->hasManyThrough('App\Cat_Subinciso','App\Cat_Inciso','id_punto','id_inciso','id');
    // }
}
