<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rel_Usuario_Menu extends Model
{
    protected $table = "rel_usuario_menu";
	//public $timestamps = false;
	protected $fillable = [
        'id_usuario', 'id_menu'
    ];

}
