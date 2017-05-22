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

    public function scopeSearch($query, $request)
    {
        if ($request->nombre != null || $request->id_menu_padre != 0)
            $query->where(function($query) use($request) {
                $query->where('p_menu.id_menu_padre', $request->id_menu_padre)->orWhere('p_menu.id', $request->id_menu_padre);
            })
            ->where('p_menu.nombre', 'LIKE', "%$request->nombre%");
        else
            $query->where('p_menu.nombre', 'LIKE', "%$request->nombre%");
        return $query;
    }

}
