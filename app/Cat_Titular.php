<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Titular extends Model
{
	protected $table = "cat_titular";
	public $timestamps = false;

	protected $fillable = [
        'titulo', 'nombre', 'apellido', 'cargo',
    ];

    public function sector()
    {
        return $this->hasOne('App\Cat_Sector', 'id_titular');
    }

    public function unidad_ejecutora()
    {
    	return $this->hasOne('App\Cat_Unidad_Ejecutora', 'id_titular');
    }
}
