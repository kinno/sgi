<?php

namespace App\Http\Controllers\Catalogo\Sector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cat_Sector;
use App\Cat_titular;
use App\Cat_Area;
use Illuminate\Support\Facades\DB;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sectores = Cat_Sector::orderBy('nombre', 'ASC')->paginate(8);
        $sectores->each(function($sectores){
            $sectores->titular;
        });
        //dd ($sectores);
        return view('Catalogo.Sector.index')
            ->with('sectores', $sectores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Cat_Area::join('Cat_Departamento', 'Cat_Area.id', '=', 'Cat_Departamento.id_area')->select('Cat_Area.*')->distinct()->get()->toArray();
        //dd($areas);
        $opciones = $this->llena_combo($areas, 'nombre');
        //dd($opciones);
        return view('Catalogo.Sector.create')
            ->with('opciones_area', $opciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_departamento' => 'required|not_in:0',
            'nombre' => 'required'
        ]);
        $titular  = new Cat_Titular($request->only(['titulo', 'apellido', 'cargo']));
        $titular->nombre = $request->titular;
        $sector  = new Cat_Sector($request->only(['nombre', 'bactivo', 'id_departamento']));
        //$sector['bactivo'] = is_null($sector['bactivo']) ? 0 : 1;
        DB::transaction(function () use ($titular, $sector) {
            $titular->save();
            $sector->id_titular = $titular->id;
            $sector->save();
        });
        return redirect()->route('Sector.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sector = Cat_Sector::find($id);
        $titular =Cat_Titular::find($sector->id_titular);
        //dd($titular);
        return view('Catalogo.Sector.edit')
            ->with('sector', $sector)
            ->with('titular',$titular);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dropdown (Request $request)
    {
        $area = Cat_Area::find($request->id);
        $departamentos = $area->departamentos->toArray();
        //dd ($departamentos);
        $opciones = $this->llena_combo($departamentos);
        //dd ($opciones);
        return $opciones;
    }

    public function llena_combo ($arreglo, $name = 'nombre')
    {
        $n = count($arreglo);
        $vacio = '<option value="0" selected="selected">- Selecciona</option>';
        $i = 0;
        $salida = "";
        $opciones = "";
        foreach ($arreglo as $key => $rows) {
            $opciones .= '<option value="'.$rows['id'].'">'.$rows[$name].'</option>';
            if ($i == 0)
                $tmp = '<option value="'.$rows['id'].'" selected="selected">'.$rows[$name].'</option>';
            $i++;
        }
        if ($i == 0)
            $salida = $vacio;
        else if ($i == 1)
            $salida = $tmp;
        else
            $salida = $vacio.$opciones;
        return $salida;
    }

}
