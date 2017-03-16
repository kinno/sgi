<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Departamento extends Model
{
    protected $table = "cat_departamento";
	public $timestamps = false;

    public function responsable()
    {
        return $this->belongsTo('App\Cat_Responsable_Area', 'id_responsable');
    }

    public function sectores()
    {
		return $this->hasMany('App\Cat_Sector', 'id_departamento');
    }

    public function area()
    {
		return $this->belongsTo('App\Cat_Area','id_area');
    }
}
