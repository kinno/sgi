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
   
    public function submenus()
    {
        return $this->hasMany('App\P_Menu', 'id_menu_padre')->orderBy('orden', 'ASC');
    }

    public function usuarios()
    {
        return $this->belongsToMany('App\User', 'rel_usuario_menu', 'id_menu', 'id_usuario');
    }

    public function menuPadre(){
    	return $this->hasOne('App\P_Menu','id','id_menu_padre');
    }

    public function scopeSearch($query, $nombre)
    {
        return $query->where('P_Menu.nombre', 'LIKE', "%$nombre%");
    }

}
