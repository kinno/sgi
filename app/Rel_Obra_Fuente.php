<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rel_Obra_Fuente extends Model
{
    protected $table = "rel_obra_fuente";
    public $timestamps = false;

    public function fuentes()
    {
        return $this->belongsTo('App\Cat_Fuente', 'id_fuente');
    }
}
