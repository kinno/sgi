<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Reporte extends Model
{
	protected $table = "cat_reporte";

	public function tipo_reporte()
	{
		return $this->belongsTo('App\Cat_Tipo_Reporte', 'id_tipo_reporte');
	}
}
