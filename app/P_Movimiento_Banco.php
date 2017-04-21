<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class P_Movimiento_Banco extends Model
{
    protected $table = "p_movimiento_banco";

    public function getFechaMovimientoAttribute($value){
    	return Carbon::parse($value)->format('d-m-Y');
    }

}
