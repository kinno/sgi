<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Oficio extends Model
{
    protected $table="p_oficio";
    protected $fillable = [
        'clave', 'id_solicitud_presupuest', 'id_usuario', 'id_estatus', 'ejercicio', 'id_sector', 'id_unidad_ejecutora', 'fecha_oficio', 'fecha_firma', 'titular', 'asunto', 'ccp', 'prefijo', 'iniciales', 'tarjeta_turno', 'texto'
    ];

    public function detalle(){
    	return $this->hasMany('App\D_Oficio','id_oficio','id');
    }

    public function tipo_solicitud(){
    	return $this->hasOne('App\Cat_Solicitud_Presupuesto','id','id_solicitud_presupuesto');
    }

    public function frase_ejercicio(){
    	return $this->hasOne('App\Cat_Ejercicio','ejercicio','ejercicio');
    }

    public function sector(){
        return $this->hasOne('App\Cat_Sector','id','id_sector');
    }

    public function estado() {
        return $this->belongsTo('App\Cat_Estatus_Oficio', 'id_estatus', 'id');
    }

}
