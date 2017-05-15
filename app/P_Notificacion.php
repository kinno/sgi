<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class P_Notificacion extends Model
{
    protected $table = "p_notificacion";

    public function getCreatedAtAttribute($value){
    	return Carbon::parse($value)->diffForHumans();
    }
}
