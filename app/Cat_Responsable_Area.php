<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Responsable_Area extends Model
{
    protected $table = "cat_responsable_area";
	public $timestamps = false;

    public function area()
    {
        return $this->hasOne('App\Cat_Area', 'id_responsable');
    }

    public function departamento()
    {
		return $this->hasOne('App\Cat_Departamento', 'id_responsable');
    }

}
