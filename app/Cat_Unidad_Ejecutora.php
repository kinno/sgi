<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Unidad_Ejecutora extends Model
{
	protected $table = "cat_unidad_ejecutora";
	public $timestamps = false;
    protected $fillable = [
        'clave', 'nombre', 'bactivo', 'id_titular', 'id_sector'
    ];

    public function titular()
    {
        return $this->belongsTo('App\Cat_Titular', 'id_titular');
    }

    public function sector()
    {
		return $this->belongsTo('App\Cat_Sector', 'id_sector');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'id_unidad_ejecutora');
    }

    public function setBactivoAttribute ($valor)
    {
        $this->attributes['bactivo'] = (boolean)($valor);
    }

    public function getBactivoAttribute ($valor)
    {
        return ($valor == 1 ? 'si' : 'no');
    }

    public function scopeSearch($query, $request)
    {
        if ($request->nombre != null || $request->id_sector != 0)
            $query->where('id_sector', $request->id_sector)->where('nombre', 'LIKE', "%$request->nombre%");
        else
            $query->where('nombre', 'LIKE', "%$request->nombre%");
        return $query;
    }

    public function obras()
    {
        return $this->belongsToMany('App\D_Obra','d_oficio','id_unidad_ejecutora', 'id_det_obra','id');
    }
}
