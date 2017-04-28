<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P_Presupuesto_Obra extends Model
{
   protected $table = "p_presupuesto_obra";

    public function setCantidadAttribute($value)
    {
        $this->attributes['cantidad'] = str_replace(",", "", $value);
    }

    public function setPrecioUnitarioAttribute($value)
    {
        $this->attributes['precio_unitario'] = str_replace(",", "", $value);
    }

    public function setImporteAttribute($value)
    {
        $this->attributes['importe'] = str_replace(",", "", $value);
    }

    public function setIvaAttribute($value)
    {
        $this->attributes['iva'] = str_replace(",", "", $value);
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = str_replace(",", "", $value);
    }
}
