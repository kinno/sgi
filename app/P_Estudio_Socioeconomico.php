<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Estudio_Socioeconomico extends Model
{
    protected $table = "p_estudio_socioeconomico";
    public $primarykey = "id";

    public function hoja1()
    {
        return $this->hasOne('App\P_Anexo_Uno_Estudiosocioeconomico', 'id', 'id_anexo_uno_estudio');
    }

    public function hoja2()
    {
        return $this->hasOne('App\P_Anexo_Dos_Estudiosocioeconomico', 'id', 'id_anexo_dos_estudio');
    }

    public function acuerdos()
    {
        return $this->hasMany('App\Rel_Estudio_Acuerdo', 'id_estudio_socioeconomico', 'id');
    }

    public function fuentes_monto()
    {
        return $this->hasMany('App\Rel_Estudio_Fuente', 'id_estudio_socioeconomico', 'id');
    }

    public function regiones()
    {
        return $this->hasMany('App\Rel_Estudio_Region', 'id_estudio_socioeconomico', 'id');
    }

    public function municipios()
    {
        return $this->hasMany('App\Rel_Estudio_Municipio', 'id_estudio_socioeconomico', 'id');
    }
}
