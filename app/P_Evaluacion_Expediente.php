<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class P_Evaluacion_Expediente extends Model
{
    protected $table = "p_evaluacion_expediente";

    public function getfechaObservacionAttribute($value){
    	return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function getobservacionesAttribute($value){
    	return nl2br($value);
    }
}
