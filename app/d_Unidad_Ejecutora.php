<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_Unidad_Ejecutora extends Model
{
    protected $table = "d_unidad_ejecutora";
	public $timestamps = false;

    public function unidad_ejecutora()
    {
		return $this->belongsTo('App\Cat_Unidad_Ejecutora', 'id_unidad_ejecutora');
    }
}
