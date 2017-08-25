<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Pagos extends Model
{
    protected $table = "p_pagos";

    public function autorizacion_pago()
    {
        return $this->belongsTo('App\P_Autorizacion_Pago', 'id_autorizacion_pago');
    }
}
