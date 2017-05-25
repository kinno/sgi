<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cat_Sector;
use App\Cat_Area;
use App\P_Menu;
use App\Cat_Tipo_Usuario;
use App\Cat_Ejercicio;
use App\Cat_Estructura_Programatica;
use App\Cat_Tipo_Fuente;
use App\Cat_Fuente;
use App\Cat_Tipo_Movimiento;
use App\Cat_Grupo_Social;
use App\Cat_Modalidad_Ejecucion;
use App\Cat_Clasificacion_Obra;
use App\Cat_Acuerdo;
use App\Cat_Region;
use App\Cat_Municipio;
use App\Cat_Cobertura;
use App\User;

trait Funciones
{
	protected $vacio = '<option value="0">- Selecciona</option>';

	public function opcionesUsuario (&$id)
	{
		$usuarios = User::where('bactivo', 1)->orderBy('name', 'ASC')->get()->toArray();
		if (count($usuarios) == 1)
			$id = $usuarios[0]['id'];
		else
			$id = 0;
		$opciones = $this->llena_combo($usuarios, 0, 'name');
		return $opciones;
	}

	public function opcionesArea ($id_area = 0, $id_departamento = 0, $siguiente = true)
	{
		$opciones = array();
		$areas = Cat_Area::join('Cat_Departamento', 'Cat_Area.id', '=', 'Cat_Departamento.id_area')->select('Cat_Area.*')->distinct()->get()->toArray();
		$opciones['area'] = $this->llena_combo($areas, $id_area);
		if ($siguiente)
			if ($id_area == 0)
				if (count($areas) == 1)
					$opciones['departamento'] = $this->opcionesDepartamento($areas[0]['id']);
				else
					$opciones['departamento'] = $this->vacio;
			else
				$opciones['departamento'] = $this->opcionesDepartamento($id_area, $id_departamento);
		return $opciones;
	}

	public function opcionesDepartamento ($id_area, $id_departamento = 0)
	{
		$area = Cat_Area::find($id_area);
		$departamentos = $area->departamentos->toArray();
		$opciones = $this->llena_combo($departamentos, $id_departamento);
		return $opciones;
	}

	public function opcionesSector ($id_sector = 0, $id_unidad_ejecutora = 0, $siguiente = true, $ids_Sector = [], $activo = false)
	{
		$opciones = array();		
		$sectores = new Cat_Sector();
		if ($activo)
			$sectores = $sectores->where('bactivo', 1);
		if (count($ids_Sector) > 0)
			$sectores = $sectores->whereIn('id', $ids_Sector);
		$sectores = $sectores->orderBy('nombre', 'ASC')->get()->toArray();
		//dd($sectores);
		$opciones['sector'] = $this->llena_combo($sectores, $id_sector, 'nombre', 'id', true, true, !$activo);
		if ($siguiente)
			if ($id_sector == 0)
				if (count($sectores) == 1)
					$opciones['ue'] = $this->opcionesUnidadEjecutora($sectores[0]['id'], 0, $activo);
				else
					$opciones['ue'] = $this->vacio;
			else
				$opciones['ue'] = $this->opcionesUnidadEjecutora($id_sector, $id_unidad_ejecutora, $activo);
		return $opciones;
	}

	public function opcionesUnidadEjecutora ($id_sector, $id_unidad_ejecutora = 0, $activo = false)
	{
		$sector = Cat_Sector::find($id_sector);
		if ($activo)
			if ($sector->bactivo == 'si')
				$ejecutoras = $sector->unidad_ejecutoras()->where('bactivo', 1)->get()->toArray();
			else
				return $this->vacio;
		else
			$ejecutoras = $sector->unidad_ejecutoras->toArray();
		$opciones = $this->llena_combo($ejecutoras, $id_unidad_ejecutora, 'nombre', 'id', true, true, !$activo);
		return $opciones;
	}

	public function opcionesMenu ($id_menu = 0)
	{
		$menus_padre = P_Menu::where('id_menu_padre', 0)->orderBy('orden', 'ASC')->get()->toArray();
		$opciones = $this->llena_combo($menus_padre, $id_menu, 'nombre', 'id', true, false);
		return $opciones;
	}

	public function opcionesTipoUsuario ($id_tipo = 0)
	{
		$tipo_usuarios = Cat_Tipo_Usuario::get()->toArray();
		$opciones = $this->llena_combo($tipo_usuarios, $id_tipo);
		return $opciones;
	}

	public function opcionesEjercicio ($ejercicio = 0, $id_programa = 0, $id_proyecto = 0, $siguiente = true)
	{
		$opciones = array();
		$ejercicios = Cat_Ejercicio::orderBy('ejercicio', 'DESC')->get()->toArray();
		$opciones['ejercicio'] = $this->llena_combo ($ejercicios, $ejercicio, 'ejercicio', 'ejercicio');
		if ($siguiente)
			if ($ejercicio == 0)
				if (count($ejercicios) == 1)
					//$opciones = array_merge_recursive($opciones, $this->opcionesPrograma($ejercicios[0]['ejercicio']));
					$opciones += $this->opcionesPrograma($ejercicios[0]['ejercicio']);
				else {
					$opciones['programa'] = $this->vacio;
					$opciones['proyecto'] = $this->vacio;
				}
			else
				//$opciones = array_merge_recursive($opciones, $this->opcionesPrograma($ejercicio, $id_programa, $id_proyecto));
				$opciones += $this->opcionesPrograma($ejercicio, $id_programa, $id_proyecto);
		return $opciones;
	}

	public function opcionesPrograma ($ejercicio, $id_programa = 0, $id_proyecto = 0, $siguiente = true)
	{
		$opciones = array();
		$programas = Cat_Estructura_Programatica::where('ejercicio', $ejercicio)->where('tipo', 'P')->orderBy('clave','ASC')->get()->toArray();
		$opciones['programa'] = $this->llena_combo($programas, $id_programa, 'clave,nombre');
		if ($siguiente)
			if ($id_programa == 0)
				if (count($programas) == 1)
					$opciones['proyecto'] = $this->opcionesProyecto($ejercicio, $programas[0]['id']);
				else
					$opciones['proyecto'] = $this->vacio;
			else
				$opciones['proyecto'] = $this->opcionesProyecto($ejercicio, $id_programa, $id_proyecto);
		return $opciones;
	}

	public function opcionesProyecto ($ejercicio, $id_programa = 0, $id_proyecto = 0)
	{
		$programa = Cat_Estructura_Programatica::find($id_programa);
		$proyectos = Cat_Estructura_Programatica::where('ejercicio', $ejercicio)->where('clave', 'like', $programa->clave.'%')->where('tipo', 'PRY')->orderBy('clave','ASC')->get()->toArray();
		$opciones = $this->llena_combo($proyectos, $id_proyecto, 'clave,nombre');
		return $opciones;
	}

	public function opcionesTipoFuente ($id_tipo = 0, $id_fuente = 0, $siguiente = true)
	{
		$opciones = array();
		$tipo_fuentes = Cat_Tipo_Fuente::orderBy('nombre', 'ASC')->get()->toArray();
		$opciones['tipo_fuente'] = $this->llena_combo($tipo_fuentes, $id_tipo);
		if ($siguiente)
			if ($id_tipo == 0)
				if (count($tipo_fuentes) == 1)
					$opciones['fuente'] = $this->opcionesFuente($tipo_fuentes[0]['id']);
				else
					$opciones['fuente'] = $this->vacio;
			else
				$opciones['fuente'] = $this->opcionesFuente($id_tipo, $id_fuente);
		return $opciones;
	}

	public function opcionesFuente ($id_tipo, $id_fuente = 0)
	{
		$tipo_fuente = Cat_Tipo_Fuente::find($id_tipo);
		$fuentes = Cat_Fuente::where('tipo', $tipo_fuente->clave)->orderBy('descripcion', 'ASC')->get()->toArray();
		$opciones = $this->llena_combo($fuentes, $id_fuente, 'descripcion');
		return $opciones;
	}

	public function opcionesTipoMovimiento ($id_tipo = 0)
	{
		$tipo_movimientos = Cat_Tipo_Movimiento::where('id', '>=', '2' )->orderBy('nombre', 'ASC')->get()->toArray();
		$opciones = $this->llena_combo($tipo_movimientos, $id_tipo);
		return $opciones;
	}

	public function opcionesModalidadEjecucion ($id_modalidad = 0)
	{
		$modalidades = Cat_Modalidad_Ejecucion::orderBy('nombre', 'ASC')->get()->toArray();
		$opciones = $this->llena_combo($modalidades, $id_modalidad);
		return $opciones;
	}

	public function opcionesClasificacion ($id_clasificacion = 0)
	{
		$clasificaciones = Cat_Clasificacion_Obra::get()->toArray();
		$opciones = $this->llena_combo($clasificaciones, $id_clasificacion);
		return $opciones;
	}

	public function opcionesCobertura ($id_cobertura = 0)
	{
		$coberturas	= Cat_Cobertura::get()->toArray();
		$opciones = $this->llena_combo($coberturas, $id_cobertura);
		return $opciones;
	}

	public function opcionesRegion ()
	{
		$regiones = Cat_Region::orderBy('nombre', 'ASC')->get()->toArray();
		$opciones = $this->llena_combo($regiones, 0, 'nombre', 'id', false);
		return $opciones;
	}

	public function opcionesMunicipio ()
	{
		$municipios = Cat_Municipio::orderBy('nombre', 'ASC')->get()->toArray();
		$opciones = $this->llena_combo($municipios, 0, 'nombre', 'id', false);
		return $opciones;
	}

	public function opcionesAcuerdo ($tipo_acuerdo)
	{
		if ($tipo_acuerdo == 'E')
			$acuerdos = Cat_Acuerdo::whereIn('id_tipo',[1, 2])->orderBy('clave', 'ASC')->get()->toArray();
		else
			$acuerdos = Cat_Acuerdo::where('id_tipo',4)->orderBy('clave', 'ASC')->get()->toArray();
		$opciones = $this->llena_combo($acuerdos, 0, 'clave,nombre', 'id', false);
		return $opciones;
	}

	public function opcionesGrupoSocial ($id_grupo = 0)
	{
		$grupos	= Cat_Grupo_Social::orderBy('nombre', 'ASC')->get()->toArray();
		$opciones = $this->llena_combo($grupos, $id_grupo, 'nombre', 'id', true, false);
		return $opciones;
	}

	public function dropdownArea (Request $request)
	{
		/*
		$area = Cat_Area::find($request->id);
		$departamentos = $area->departamentos->toArray();
		$opciones = $this->llena_combo($departamentos, 0, 'nombre', 'id', true, true);*/
		$opciones = $this->opcionesDepartamento($request->id);
		return $opciones;
	}


	public function dropdownSector (Request $request)
	{
		/*$sector = Cat_Sector::find($request->id);
		$ejecutoras = $sector->unidad_ejecutoras->toArray();
		$opciones = $this->llena_combo($ejecutoras);*/
		$opciones = $this->opcionesUnidadEjecutora($request->id);
		return $opciones;
	}

	public function dropdownEjercicio (Request $request)
	{
		/*$programa = Cat_Estructura_Programatica::where('ejercicio', $request->ejercicio)->where('tipo', 'P')->orderBy('clave','ASC')->get()->toArray();
		$opciones = $this->llena_combo($programa, 0, 'clave,nombre');*/
		$opciones = $this->opcionesPrograma($request->ejercicio);
		return $opciones;
	}

	public function dropdownPrograma (Request $request)
	{
		/*$programa = Cat_Estructura_Programatica::find($request->id);
		$proyectos = Cat_Estructura_Programatica::where('ejercicio', $request->ejercicio)->where('clave', 'like', $programa->clave.'%')->where('tipo', 'PRY')->orderBy('clave','ASC')->get()->toArray();
		$opciones = $this->llena_combo($proyectos, 0, 'clave,nombre');
		*/
		$opciones = $this->opcionesProyecto($request->ejercicio, $request->id);
		return $opciones;
	}

	public function dropdownTipoFuente (Request $request)
	{
		/*$tipo_fuente = Cat_Tipo_Fuente::find($request->id);
		$fuentes = Cat_Fuente::where('tipo', $tipo_fuente->clave)->orderBy('descripcion', 'ASC')->get()->toArray();
		$opciones = $this->llena_combo($fuentes, 0, 'descripcion');*/
		$opciones = $this->opcionesFuente($request->id);
		return $opciones;
	}

	public function llena_combo ($arreglo, $valor = 0, $name = 'nombre', $id = 'id', $select_simple = true, $una_opcion = true, $inactivo = false)
	{
		$n = count($arreglo);
		$selected = false;
		if ($select_simple) {
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
			$clase = '';
			$espacios = '';
			if ($inactivo)
				if (isset($rows['bactivo']))
					if ($rows['bactivo'] == 'no') {
						$clase = ' class=inactivo';
						$espacios = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(inactivo) ';
					}
					/*else
						$espacios = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';*/
			for ($j = 0; $j < $ncampos; $j++)
				if ($nombre_opcion == '')
					$nombre_opcion = $rows[$acampos[$j]];
				else
					$nombre_opcion .= ' ' . $rows[$acampos[$j]];
			if ($valor == $rows[$id]) {
				$selected = true;
				$opciones .= '<option'.$clase.' value="'.$rows[$id].'" selected="selected">'.$nombre_opcion.$espacios.'</option>'.chr(10);
			}
			else
				$opciones .= '<option'.$clase.' value="'.$rows[$id].'">'.$nombre_opcion.$espacios.'</option>'.chr(10);
			/*if ($i == 0)
				$tmp = '<option value="'.$rows[$id].'" selected="selected">'.$nombre_opcion.'</option>';
			$i++;*/
		}
		if ($n == 0)
			$salida = $vacio;
		else if ($n == 1) {
			if (!$una_opcion)
				if ($selected)
					$salida = $vacio1.$opciones;
				else
					$salida = $vacio.$opciones;
			else
				$salida = $opciones;
		}
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