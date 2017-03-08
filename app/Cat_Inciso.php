<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Inciso extends Model
{
    protected $table = "cat_inciso";
    public $timestamp = false;

    public function subinciso(){
    	return $this->hasMany('App\Cat_Subinciso','id_inciso','id');
    }

}
