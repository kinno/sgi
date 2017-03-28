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

    public function setBactivoAttribute ($valor)
    {
        $this->attributes['bactivo'] = (boolean)($valor);
    }

    public function getBactivoAttribute ($valor)
    {
        return ($valor == 1 ? 'si' : 'no');
    }

    public function scopeSearch($query, $nombre)
    {
        return $query->where('nombre', 'LIKE', "%$nombre%");
    }
}
