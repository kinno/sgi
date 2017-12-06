<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Autorizacion_Pago extends Model
{
    protected $table = "p_autorizacion_pago";

    public function contrato(){
    	return $this->hasOne('App\P_Contrato','id','id_contrato');
    }

    public function empresa(){
    	return $this->hasOne('App\Cat_Empresa','id','id_empresa');
    }

    public function obra(){
    	//return $this->hasOne('App\D_Obra','id','id_obra');
        return $this->belongsTo('App\P_Autorizacion_Pago', 'id_det_obra');
    }

    public function unidad_ejecutora()
    {
        return $this->belongsTo('App\Cat_Unidad_Ejecutora', 'id_unidad_ejecutora');
    }

    public function estatus(){
        return $this->hasOne('App\Cat_Estatus_Ap','id','id_estatus');
    }

     public function tipo_ap(){
        return $this->hasOne('App\Cat_Tipo_Ap','id','id_tipo_ap');
    }

    public function fuente(){
        return $this->hasOne('App\Cat_Fuente','id','id_fuente');
    }


    public function sector(){
        return $this->hasOne('App\Cat_Sector','id','id_sector');

    // public function sector()
    // {
    //     return $this->belongsTo('App\Cat_Sector', 'id_sector');
    }

    public function pagos()
    {
        return $this->hasMany('App\P_Pagos', 'id_autorizacion_pago');

    }
}
