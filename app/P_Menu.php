<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Menu extends Model
{
    protected $table = "p_menu";
	public $timestamps = true;
    protected $fillable = [
        'nombre', 'ruta', 'blink', 'orden', 'descripcion', 'id_menu_padre'
    ];
   

    public function usuarios()
    {
        $this->belongsToMany('App\User', 'rel_usuario_menu', 'id_usuario', 'id_menu');
    }

    public function menuPadre(){
    	return $this->hasOne('App\P_Menu','id','id_menu_padre');
    }

    
}
