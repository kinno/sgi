<?php

namespace App\Http\Controllers\TechoFinanciero;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use Illuminate\Support\Facades\DB;
use App\P_Techo;
use App\D_Techo;
use App\Cat_Ejercicio;
use App\Cat_Unidad_Ejecutora;
use App\Cat_Sector;
use App\Cat_Tipo_Fuente;
use App\Cat_Fuente;
use App\Cat_Tipo_Movimiento;
use App\Cat_Estructura_Programatica;
use App\User;

class TechoController extends Controller
{
    use Funciones;

    protected $rules = [
            'ejercicio' => 'not_in:0',
            'id_unidad_ejecutora' => 'not_in:0',
            'id_proyecto_ep' => 'not_in:0',
            'id_tipo_fuente' => 'not_in:0',
            'id_fuente' => 'not_in:0',
            'id_tipo_movimiento' => 'not_in:0',
            'monto' => 'required|numeric|not_in:0',
            'observaciones' => 'required'
        ];
    protected $rules2 = [
            'monto' => 'required|numeric|not_in:0',
            'observaciones' => 'required'
        ];
    protected $rules3 = [
            'id_tipo_movimiento' => 'not_in:0',
            'monto' => 'required|numeric|not_in:0',
            'observaciones' => 'required'
        ];
    protected $messages = [
            'ejercicio.not_in'                  => 'Seleccione Ejercicio',
            'id_unidad_ejecutora.not_in'        => 'Seleccione Unidad Ejecutora',
            'id_proyecto_ep.not_in'             => 'Seleccione Proyecto de la EP',
            'id_tipo_fuente.not_in'             => 'Seleccione Tipo de Fuente',
            'id_fuente.not_in'                  => 'Seleccione Fuente',
            'id_tipo_movimiento.not_in'         => 'Seleccione Tipo de Movimiento',
            'monto.required'                    => 'Introduzca monto',
            'monto.not_in'                      => 'Introduzca monto',
            'observaciones.required'            => 'Introduzca observaciones'
        ];
    protected $barraMenu = array(
            'botones' => array([
                'id'    => 'btnGuardar',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-save',
                'title' => 'Guardar',
                'texto' => 'Guardar'
            ], [
                'id'    => 'btnRegresar',
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-arrow-left',
                'title' => 'Regresar',
                'texto' => 'Regresar'
            ] ));
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $ids_Sector = $this->getIdsSectores();
        $montos = DB::table('p_techo')->select('p_techo.ejercicio', 'cat_unidad_ejecutora.nombre as ue', 'cat_sector.nombre as sector', 'cat_estructura_programatica.nombre as proyecto', 'cat_tipo_fuente.nombre as tipo_fuente', 'cat_fuente.descripcion as fuente', 'd_techo.*')
            ->join('cat_unidad_ejecutora', function ($join) use ($request, $ids_Sector) {
                $join->on('p_techo.id_unidad_ejecutora', '=', 'cat_unidad_ejecutora.id');
                $join->whereIn('id_sector', $ids_Sector);
                if ($request->id_sector != null && $request->id_sector != '0')
                    $join->where('id_sector', $request->id_sector);
            })
            ->join('cat_sector', 'cat_unidad_ejecutora.id_sector', '=', 'cat_sector.id')
            ->join('cat_estructura_programatica', 'p_techo.id_proyecto_ep', '=', 'cat_estructura_programatica.id')
            ->join('cat_tipo_fuente', 'p_techo.id_tipo_fuente', '=', 'cat_tipo_fuente.id')
            ->join('cat_fuente', 'p_techo.id_fuente', '=', 'cat_fuente.id')
            ->join('d_techo', 'p_techo.id', '=', 'd_techo.id_techo')           
            ->where(function ($query) use ($request) {
                if ($request->ejercicio != null && $request->ejercicio != '0')
                    $query->where('p_techo.ejercicio', $request->ejercicio);
            })
            ->orderBy('p_techo.ejercicio')->orderBy('cat_sector.nombre')
            ->orderBy('cat_unidad_ejecutora.nombre')->orderBy('cat_tipo_fuente.nombre')
            ->orderBy('cat_fuente.descripcion')->orderBy('cat_estructura_programatica.nombre')
            ->orderBy('d_techo.id_tipo_movimiento')->orderBy('d_techo.created_at')->get()->toArray();
        $tabla = $this->tabla($montos);
        //dd($tabla);
        $opciones = array();
        $opciones += $this->opcionesEjercicio ($request->ejercicio, 0, 0, false);
        $opciones += $this->opcionesSector ($request->id_sector, 0, false, $ids_Sector);
        return view('TechoFinanciero.index')
            ->with('montos', $tabla)
            ->with('opciones', $opciones);
    }

    public function create()
    {
        $ids_Sector = $this->getIdsSectores();
        $opciones = $this->opcionesEjercicio ();
        $opciones += $this->opcionesSector(0, 0, true, $ids_Sector);
        $opciones += $this->opcionesTipoFuente();
        return view('TechoFinanciero.create')
            ->with('opciones', $opciones)
            ->with('barraMenu', $this->barraMenu);
    }

    public function store(Request $request)
    {
        //return ($request->all());
        $request->merge(['monto' => str_replace(",", "", $request->monto)]);
        $validator = \Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        try {
            $p_techo  = P_Techo::where('ejercicio', $request->ejercicio)->where('id_unidad_ejecutora', $request->id_unidad_ejecutora)->where('id_tipo_fuente', $request->id_tipo_fuente)->where('id_fuente', $request->id_fuente)->where('id_proyecto_ep', $request->id_proyecto_ep)->first();
            if (count($p_techo) > 0) {
                $data['mensaje'] = "Ya se encuentra guardada esta combinación.<br>Ejercicio - Unidad Ejecutora - Tipo Fuente - Fuente - Proyecto";
                $data['error'] = 2;
                return $data;
            }
            $p_techo  = new P_Techo($request->only(['ejercicio', 'id_unidad_ejecutora', 'id_proyecto_ep', 'id_tipo_fuente', 'id_fuente']));
            $d_techo = new D_Techo($request->only(['monto', 'observaciones']));
            $p_techo->techo = $request->monto;
            $d_techo->id_tipo_movimiento = 1;  // Autorización
            DB::transaction(function () use ($p_techo, $d_techo) {
                $p_techo->save();
                $d_techo->id_techo = $p_techo->id;
                $d_techo->save();
            });
            $data['mensaje'] = "Datos guardados correctamente";
            $data['error'] = 1;
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
    }

    public function edit($id)
    {
        $d_techo = D_Techo::with(['techo.unidad_ejecutora.sector', 'techo.proyecto', 'techo.tipo_fuente', 'techo.fuente', 'movimiento'])->find($id);
        $programa = Cat_Estructura_Programatica::where('ejercicio', $d_techo->techo->ejercicio)->where('tipo', 'P')->where('clave', 'like', substr($d_techo->techo->proyecto->clave, 0, 8).'%')->first();
        //dd($d_techo);
        return view('TechoFinanciero.edit')
            ->with('d_techo', $d_techo)
            ->with('programa', $programa)
            ->with('barraMenu', $this->barraMenu);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['monto' => str_replace(",", "", $request->monto)]);
        //dd($request->toArray());
        $validator = Validator::make($request->all(), $this->rules2, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        try {
            // validar montos con lo autorizado
            $d_techo = D_Techo::find($id);
            $p_techo = $d_techo->techo;
            if ($request->id_tipo_movimiento == '3')
                $p_techo->techo = $p_techo->techo + $d_techo->monto - $request->monto;
            else
                $p_techo->techo = $p_techo->techo - $d_techo->monto + $request->monto;
            if ($p_techo->techo < 0) {
                $data['mensaje'] = "La suma de todos los montos no puede ser negativa";
                $data['error'] = 2;
                return $data;
            }
            $d_techo->monto = $request->monto;
            $d_techo->observaciones = $request->observaciones;
            DB::transaction(function () use ($d_techo, $p_techo) {
                $d_techo->save();
                $p_techo->save();
            });
            $data['mensaje'] = "Datos guardados correctamente";
            $data['error'] = 1;
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
    }

    public function agregar($id)
    {
        $d_techo = D_Techo::with(['techo.unidad_ejecutora.sector', 'techo.proyecto', 'techo.tipo_fuente', 'techo.fuente', 'movimiento'])->find($id);
        $programa = Cat_Estructura_Programatica::where('ejercicio', $d_techo->techo->ejercicio)->where('tipo', 'P')->where('clave', 'like', substr($d_techo->techo->proyecto->clave, 0, 8).'%')->first();
        $opciones_tipo_movimiento = $this->opcionesTipoMovimiento();
        return view('TechoFinanciero.agregar')
            ->with('d_techo', $d_techo)
            ->with('programa', $programa)
            ->with('opciones_tipo_movimiento', $opciones_tipo_movimiento)
            ->with('barraMenu', $this->barraMenu);
    }

    public function guarda(Request $request, $id)
    {
        $request->merge(['monto' => str_replace(",", "", $request->monto)]);
        //return ($request->all());
        $validator = \Validator::make($request->all(), $this->rules3, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        try {
            // validar montos con lo autorizado
            $p_techo = P_Techo::find($id);
            if ($request->id_tipo_movimiento == '3')
                $p_techo->techo = $p_techo->techo - $request->monto;
            else
                $p_techo->techo = $p_techo->techo + $request->monto;
            if ($p_techo->techo < 0) {
                $data['mensaje'] = "La suma de todos los montos no puede ser negativa";
                $data['error'] = 2;
                return $data;
            }
            $d_techo = new D_Techo($request->only(['id_tipo_movimiento', 'monto', 'observaciones']));
            $d_techo->id_techo = $id;
            DB::transaction(function () use ($p_techo, $d_techo) {
                $p_techo->save();
                $d_techo->save();
            });
            $data['mensaje'] = "Datos guardados correctamente";
            $data['error'] = 1;
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
    }

    public function destroy($id)
    {
        $data = array();
        try {
            $d_techo = D_Techo::find($id);
            $p_techo = $d_techo->techo;
            if ($d_techo->id_tipo_movimiento == 3)
                $p_techo->techo = $p_techo->techo + $d_techo->monto;
            else if ($d_techo->id_tipo_movimiento == 2)
                $p_techo->techo = $p_techo->techo - $d_techo->monto;
            if ($p_techo->techo < 0 && $d_techo->id_tipo_movimiento != 1) {
                $data['mensaje'] = "La suma de todos los montos no puede ser negativa";
                $data['error'] = 2;
                return $data;
            }
            DB::transaction(function () use ($p_techo, $d_techo) {
                if ($d_techo->id_tipo_movimiento == 1)
                    $p_techo->delete();
                else
                    $p_techo->save();
                $d_techo->delete();
            });
            $data['mensaje'] = "Monto del Techo Financiero eliminado correctamente: ".$d_techo->observaciones;
            $data['error'] = 1;
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al eliminar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
    }

    public function tabla($datos)
    {
        $tabla = array();
        $sector = ''; $ue = ''; $proyecto = ''; $tipo_fuente = ''; $fuente = ''; $fecha = '';
        $keys = array('columna', 'techo', 'id', 'id_tipo_movimiento', 'created_at', 'monto', 'observaciones', 'total', 'clase_row', 'clase_numero', 'n_detalle');
        $total = array_fill(1, 4, 0);
        $ren = array_fill(1, 5, 0);
        $i = 0;
        reset($datos);
        $fila = current($datos);
        while ($fila) {
            // checar primero
            if ($sector = '' || $sector != $fila->sector) {
                $tabla[] = array_fill_keys($keys, '');
                $tabla[$i]['clase_row'] = "class=grupo1";
                $total[1] = 0;
                $ren[1] = $i;
                $tabla[$i++]['columna'] = $fila->sector;
            }
            if ($ue = '' || $ue != $fila->ue) {
                $tabla[] = array_fill_keys($keys, '');
                $tabla[$i]['clase_row'] = 'class=grupo2';
                $total[2] = 0;
                $ren[2] = $i;
                $tabla[$i++]['columna'] = $fila->ue;
            }
            if ($proyecto = '' || $proyecto != $fila->sector.$fila->ue.$fila->proyecto) {
                $tabla[] = array_fill_keys($keys, '');
                $tabla[$i]['clase_row'] = 'class=grupo3';
                $total[3] = 0;
                $ren[3] = $i;
                $tabla[$i++]['columna'] = $fila->proyecto;
            }
            if ($fuente = '' || $fuente != $fila->sector.$fila->ue.$fila->proyecto.$fila->tipo_fuente.$fila->fuente) {
                $tabla[] = array_fill_keys($keys, '');
                $tabla[$i]['clase_row'] = 'class=grupo4';
                $total[4] = 0;
                $ren[4] = $i;
                $tabla[$i++]['columna'] = '('.$fila->tipo_fuente.') '.$fila->fuente;
                $ren[5] = $i;
                $n_grupo4 = 0;
            }
            $n_grupo4++;
            // todos
            foreach ($fila as $clave => $valor) {
                if ($clave == 'monto')
                    $tabla[$i][$clave] = number_format($valor, 2);
                else
                    $tabla[$i][$clave] = $valor;
            }
            //$tabla[] = $fila;
            for ($j = 1; $j <= 4; $j++) {
                if ($fila->id_tipo_movimiento == '3')
                    $total[$j] -= $fila->monto;
                else
                    $total[$j] += $fila->monto;
            }
            // Ampliación
            if ($fila->id_tipo_movimiento == '2') {
                $tabla[$i]['clase_numero'] = 'class=num_verde';
                $tabla[$i]['monto'] = '+ '.$tabla[$i]['monto'];

            }
            // Reducción
            else if ($fila->id_tipo_movimiento == '3') {
                $tabla[$i]['clase_numero'] = 'class=num_rojo';
                $tabla[$i]['monto'] = '- '.$tabla[$i]['monto'];
            }
            // Autorización
            else
                $tabla[$i]['clase_numero'] = '';
            $tabla[$i]['clase_row'] = '';
            $tabla[$i]['created_at'] = substr($tabla[$i]['created_at'], 0, 10);
            $tabla[$i]['n_detalle'] = '';
            $tabla[$i++]['columna'] = '';

            $sector = $fila->sector;
            $ue = $fila->ue;
            $proyecto = $fila->sector.$fila->ue.$fila->proyecto;
            $fuente = $fila->sector.$fila->ue.$fila->proyecto.$fila->tipo_fuente.$fila->fuente;
            // checar último
            $fila = next($datos);
            if (!$fila || $fuente != $fila->sector.$fila->ue.$fila->proyecto.$fila->tipo_fuente.$fila->fuente) {
                $tabla[$ren[4]]['monto'] = number_format($total[4], 2);
                $tabla[$ren[5]]['n_detalle'] = $n_grupo4;
            }
            if (!$fila || $proyecto != $fila->sector.$fila->ue.$fila->proyecto) {
                $tabla[$ren[3]]['monto'] = number_format($total[3], 2);
            }
            if (!$fila || $ue != $fila->ue) {
                $tabla[$ren[2]]['monto'] = number_format($total[2], 2);
            }
            if (!$fila || $sector != $fila->sector) {
                $tabla[$ren[1]]['monto'] = number_format($total[1], 2);
            }
        }
        return $tabla;
    }

}