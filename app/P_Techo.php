<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Techo extends Model
{
    protected $table = "p_techo";
    protected $fillable = [
        'ejercicio', 'id_unidad_ejecutora', 'id_proyecto_ep', 'id_tipo_fuente', 'id_fuente', 'techo'
    ];

    public function montos()
    {
    	return $this->hasMany('App\D_Techo', 'id_techo');
    }

    public function unidad_ejecutora()
    {
        return $this->belongsTo('App\Cat_Unidad_Ejecutora', 'id_unidad_ejecutora');
    }

    public function proyecto()
    {
        return $this->belongsTo('App\Cat_Estructura_Programatica', 'id_proyecto_ep');
    }

    public function tipo_fuente()
    {
        return $this->belongsTo('App\Cat_Tipo_Fuente', 'id_tipo_fuente');
    }

    public function fuente()
    {
        return $this->belongsTo('App\Cat_Fuente', 'id_fuente');
    }
}
