<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cat_Sector;
use App\Cat_Area;
use App\Cat_Estructura_Programatica;
use App\Cat_Tipo_Fuente;
use App\Cat_Fuente;
use App\User;

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

    public function dropdownEjercicio (Request $request)
    {
        $programa = Cat_Estructura_Programatica::where('ejercicio', $request->ejercicio)->where('tipo', 'P')->orderBy('clave','ASC')->get()->toArray();
        $opciones = $this->llena_combo($programa, 0, 'clave,nombre');
        return $opciones;
    }

    public function dropdownPrograma (Request $request)
    {
        $programa = Cat_Estructura_Programatica::find($request->id);
        $proyectos = Cat_Estructura_Programatica::where('ejercicio', $request->ejercicio)->where('clave', 'like', $programa->clave.'%')->where('tipo', 'PRY')->orderBy('clave','ASC')->get()->toArray();
        $opciones = $this->llena_combo($proyectos, 0, 'clave,nombre');
        return $opciones;
    }

    public function dropdownTipoFuente (Request $request)
    {
        $tipo_fuente = Cat_Tipo_Fuente::find($request->id);
        $fuentes = Cat_Fuente::where('tipo', $tipo_fuente->clave)->orderBy('descripcion', 'ASC')->get()->toArray();
        $opciones = $this->llena_combo($fuentes, 0, 'descripcion');
        return $opciones;
    }

    public function llena_combo ($arreglo, $valor = 0, $name = 'nombre', $id = 'id', $selecciona = true)
    {
        $n = count($arreglo);
        $selected = false;
        if ($selecciona) {
	        $vacio = '<option value="0" selected="selected">- Selecciona</option>';
	        $vacio1 = '<option value="0">- Selecciona</option>';
	    }
	    else {
	    	$vacio = '';
	    	$vacio1 = '';
	    }
        $i = 0;
        $salida = "";
        $opciones = "";
        $acampos = explode(",", $name);
        $ncampos = count($acampos);
        foreach ($arreglo as $key => $rows) {
            $nombre_opcion = '';
            for ($j = 0; $j < $ncampos; $j++)
            	if ($nombre_opcion == '')
            		$nombre_opcion = $rows[$acampos[$j]];
            	else
            		$nombre_opcion .= ' ' . $rows[$acampos[$j]];
            if ($valor == $rows[$id]) {
                $selected = true;
                $opciones .= '<option value="'.$rows[$id].'" selected="selected">'.$nombre_opcion.'</option>';
            }
            else
                $opciones .= '<option value="'.$rows[$id].'">'.$nombre_opcion.'</option>'.chr(10);
            if ($i == 0)
                $tmp = '<option value="'.$rows[$id].'" selected="selected">'.$nombre_opcion.'</option>';
        }
        if ($n == 0)
            $salida = $vacio;
        else if ($n == 1)
            //$salida = $tmp;
        	$salida = $opciones;
        else if ($selected)
            $salida = $vacio1.chr(10).$opciones;
        else
        	$salida = $vacio.chr(10).$opciones;
        return $salida;
    }

    public function getIdsSectores ($id_usuario = 0)
    {
        if ($id_usuario == 0)
        	$usuario = \Auth::user();
        else
        	$usuario = User::find($id_usuario);
    	$sectores = $usuario->sectores;
        $arreglo_ids = [];
        foreach ($sectores as $sector)
            $arreglo_ids[] = $sector->id;
        return $arreglo_ids;
    }
}