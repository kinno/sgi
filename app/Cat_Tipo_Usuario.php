<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Tipo_Usuario extends Model
{
    protected $table = "cat_tipo_usuario";
	public $timestamps = false;
	protected $fillable = [
        'nombre'
    ];

    public function users()
    {
		return $this->hasMany('App\User', 'id_tipo_usuario');
    }
}
