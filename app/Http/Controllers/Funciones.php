<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cat_Sector;
use App\Cat_Area;

trait Funciones
{
	
	public function dropdownArea (Request $request)
    {	
        //return array('uno' => 'si');
        $area = Cat_Area::find($request->id);
        $departamentos = $area->departamentos->toArray();
        $opciones = $this->llena_combo($departamentos);
        return $opciones;
    }


	public function dropdownSector (Request $request)
    {
        $sector = Cat_Sector::find($request->id);
        $ejecutoras = $sector->unidad_ejecutoras->toArray();
        $opciones = $this->llena_combo($ejecutoras);
        return $opciones;
    }

    public function llena_combo ($arreglo, $valor = 0, $name = 'nombre', $id = 'id')
    {
        $n = count($arreglo);
        $vacio = '<option value="0" selected="selected">- Selecciona</option>';
        $vacio1 = '<option value="0">- Selecciona</option>';
        $i = 0;
        $salida = "";
        $opciones = "";
        foreach ($arreglo as $key => $rows) {
            if ($valor == $rows[$id])
                $opciones .= '<option value="'.$rows[$id].'" selected="selected">'.$rows[$name].'</option>';
            else
                $opciones .= '<option value="'.$rows[$id].'">'.$rows[$name].'</option>';
            if ($i == 0)
                $tmp = '<option value="'.$rows[$id].'" selected="selected">'.$rows[$name].'</option>';
        }
        if ($n == 0)
            $salida = $vacio;
        else if ($n == 1)
            $salida = $tmp;
        else
            $salida = $vacio1.$opciones;
        return $salida;
    }
}