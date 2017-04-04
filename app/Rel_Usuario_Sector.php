<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rel_Usuario_Sector extends Model
{
    protected $table = "rel_usuario_sector";
	//public $timestamps = true;
	protected $fillable = [
        'id_usuario', 'id_sector'
    ];
    /*protected $fillable = [
        'id_usuario', 'id_sector', 'created_at', 'updated_at'
    ];*/
}
