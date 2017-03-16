<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Unidad_Ejecutora extends Model
{
	protected $table = "cat_unidad_ejecutora";
	public $timestamps = false;

    public function titular()
    {
        return $this->belongsTo('App\Cat_Titular', 'id_titular');
    }

    public function sector()
    {
		return $this->belongsTo('App\Cat_Sector', 'id_sector');
    }

    public function claves()
    {
		return $this->hasMany('App\d_Unidad_Ejecutora', 'id_unidad_ejecutora');
    }
}
