<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Area extends Model
{
    protected $table = "cat_area";
	public $timestamps = false;

    public function responsable()
    {
        return $this->belongsTo('App\Cat_Responsable_Area', 'id_responsable');
    }

    public function departamentos()
    {
		return $this->hasMany('App\Cat_Departamento', 'id_area');
    }

}
