<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_Acuerdo extends Model
{
    protected $table = "cat_acuerdo";
    public $timestamps = false;

    public function obras()
    {
        return $this->belongsToMany('App\D_Obra', 'rel_obra_acuerdo', 'id_acuerdo', 'id_det_obra');
    }

}
