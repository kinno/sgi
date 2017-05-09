<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rel_Estudio_Expediente_Obra extends Model
{
    protected $table = "rel_estudio_expediente_obra";

    public function estudio(){
    	return $this->hasOne('App\P_Estudio_Socioeconomico','id','id_estudio_socioeconomico');
    }

    public function expediente(){
    	return $this->hasOne('App\P_Expediente_Tecnico','id','id_expediente_tecnico');
    }
    public function obra(){
    	return $this->hasOne('App\D_Obra','id','id_det_obra');
    }

    
    
}
