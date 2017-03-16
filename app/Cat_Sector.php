<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Sector extends Model
{
    protected $table = "cat_sector";
	public $timestamps = false;

	protected $fillable = [
        'nombre', 'bactivo', 'id_titular', 'id_departamento'
    ];

    
    /*protected $hidden = [
        'id',
    ];*/

    /*public function titular()
    {
		return $this->hasOne('App\Cat_Titular');
    }*/

    public function titular()
    {
        return $this->belongsTo('App\Cat_Titular', 'id_titular');
    }

    public function unidad_ejecutoras()
    {
		return $this->hasMany('App\Cat_Unidad_Ejecutora', 'id_sector');
    }

    public function departamento()
    {
		return $this->belongsTo('App\Cat_Departamento', 'id_departamento');
    }

    public function getBactivoAttribute ($valor) {
        return ($valor == 1 ? 'si' : 'no');
    }

    public function setBactivoAttribute ($valor) {
        $this->attributes['bactivo'] = (boolean)($valor);
    }
}
