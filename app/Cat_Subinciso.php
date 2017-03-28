<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Subinciso extends Model
{
     protected $table = "cat_subinciso";
    public $timestamps = false;

    public function inciso(){
    	return $this->hasOne('App\Cat_Inciso','id','id_inciso');
    }

}
