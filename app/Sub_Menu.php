<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_Menu extends Model
{
    protected $table = "p_menu";
	public $timestamps = true;
	protected $fillable = [
        'nombre', 'ruta', 'blink', 'orden', 'descripcion', 'id_menu_padre'
    ];
}
