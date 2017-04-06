<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Anexo_Uno_Estudiosocioeconomico extends Model
{
    protected $table = "p_anexo_uno_estudiosocioeconomico";

    public function sector()
    {
        return $this->hasOne('App\Cat_Sector', 'id', 'id_sector');
    }

    public function unidad_ejecutora()
    {
        return $this->hasOne('App\Cat_Unidad_Ejecutora', 'id', 'id_unidad_ejecutora');
    }
}
