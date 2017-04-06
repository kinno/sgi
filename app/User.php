<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'id_tipo_usuario', 'id_unidad_ejecutora', 'id_departamento',
        'iniciales', 'bactivo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tipo_usuario()
    {
        return $this->belongsTo('App\Cat_Tipo_Usuario', 'id_tipo_usuario');
    }

    public function unidad_ejecutora()
    {
        return $this->belongsTo('App\Cat_Unidad_Ejecutora', 'id_unidad_ejecutora');
    }

    public function sectores()
    {
        return $this->belongsToMany('App\Cat_Sector', 'rel_usuario_sector', 'id_usuario', 'id_sector')->withTimestamps();
    }

    public function menus()
    {
        return $this->belongsToMany('App\P_Menu', 'rel_usuario_menu', 'id_usuario', 'id_menu')->withTimestamps();
         // return $this->hasManyThrough('App\P_Menu','App\Rel_Usuario_Menu','id_usuario','id','id');
        // return $this->hasMany('App\Rel_Usuario_Menu','id_usuario','id');
    }

    public function setBactivoAttribute ($valor)
    {
        $this->attributes['bactivo'] = (boolean)($valor);
    }

    public function getBactivoAttribute ($valor)
    {
        return ($valor == 1 ? 'si' : 'no');
    }

    public function setPasswordAttribute ($valor)
    {
        $this->attributes['password'] = bcrypt($valor);
    }

    public function scopeSearch($query, $name)
    {
        return $query->where('name', 'LIKE', "%$name%");
    }
    
}
