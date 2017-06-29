<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class D_Obra extends Model
{
    protected $table = "d_obra";
    protected $fillable = [
        'id_obra', 'ejercicio', 'nombre', 'justificacion', 'caracteristicas', 'localidad', 'id_sector', 'id_unidad_ejecutora',
        'id_grupo_social', 'id_modalidad_ejecucion', 'id_proyecto_ep', 'id_clasificacion_obra', 'id_usuario', 'id_cobertura',
        'id_municipio', 'asignado', 'autorizado', 'ejercido', 'anticipo', 'retenciones', 'comprobado', 'pagado'
    ];

    public function sector()
    {
        return $this->belongsTo('App\Cat_Sector', 'id_sector');
    }

    public function unidad_ejecutora()
    {
        return $this->belongsTo('App\Cat_Unidad_Ejecutora', 'id_unidad_ejecutora');
    }

    public function proyecto()
    {
        return $this->belongsTo('App\Cat_Estructura_Programatica', 'id_proyecto_ep');
    }

    public function acuerdos()
    {
        return $this->belongsToMany('App\Cat_Acuerdo', 'rel_obra_acuerdo', 'id_det_obra', 'id_acuerdo');
    }

    public function fuentes()
    {
        return $this->belongsToMany('App\Cat_Fuente','rel_obra_fuente','id_det_obra', 'id_fuente')->withPivot('monto', 'cuenta','partida','tipo_fuente');
    }

    public function regiones()
    {
        return $this->belongsToMany('App\Cat_Region', 'rel_obra_region', 'id_det_obra', 'id_region');
    }

    public function municipios()
    {   
        return $this->belongsToMany('App\Cat_Municipio', 'rel_obra_municipio', 'id_det_obra', 'id_municipio');
    }

    public function relacion()
    {
        return $this->hasOne('App\Rel_Estudio_Expediente_Obra', 'id_det_obra', 'id');
    }

    public function modalidad_ejecucion(){
        return $this->belongsTo('App\Cat_Modalidad_Ejecucion', 'id_modalidad_ejecucion');
    }


    public function municipio_reporte(){
        return $this->hasOne('App\Cat_Municipio_Reporte','id','id_municipio');
   }
   
    public function tipo_obra()
    {
        return $this->belongsTo('App\Cat_Tipo_Obra', 'id_tipo_obra');
    }

    public function detalles_oficio()
    {
        return $this->hasMany('App\D_Oficio', 'id_det_obra');
    }

}
