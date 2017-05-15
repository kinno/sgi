<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class D_Techo extends Model
{
    protected $table = "d_techo";
    protected $fillable = [
        'monto', 'observaciones', 'id_techo', 'id_tipo_movimiento'
    ];

    public function techo()
    {
        return $this->belongsTo('App\P_Techo', 'id_techo');
    }

    public function movimiento()
    {
        return $this->belongsTo('App\Cat_Tipo_Movimiento', 'id_tipo_movimiento');
    }
}
