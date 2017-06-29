@php
    $inversion = 0.00;
    $total_sin_iva = 0.00;
    $total_iva = 0.00;
    $total = 0.00;
    foreach ($oficioAsignacion as $value) {
        $inversion+=$value->asignado; 
    }
@endphp
<style type="text/css">
     @font-face {
        font-family: gotham-book;
        src: url({{ asset('fonts/Gotham-Book.ttf') }}) format("truetype");
        
    }
    @font-face {
       
        font-family: gotham-medium;
        src: url({{ asset('fonts/Gotham-Medium.ttf') }}) format("truetype");
    }
html {
    font-family: gotham-book !important;

}
.contenedor {
    font-size: 14px;
    margin-top: 100px;
    margin-bottom: 0px;
    height: 100%;
    page-break-after: always;
   
}
table.content td{border: #000 1px solid;}
table tfoot{bottom: 0px;}
.encabezado{background-color: #7DAB49;font-family: gotham-medium !important; text-align: center; border-color: #7DAB49;}
.punto{text-align: center; font-family: gotham-medium !important; background-color: #EEEEEE;}
.num{text-align: right;}
.c{text-align: center;}
.j{text-align: justify;}
div.breakNow { page-break-before:avoid; page-break-after:always; }
div.header { width: 100%;height:10%; top: 0px;}
/*div.cont { height: 89% ; border: #c4c4c4 1px solid; page-break-after: always; font-size: 12px !important;}*/
div.foot { width: 100%;height:1% ;bottom: 0px;  position: fixed;}
table {font-size: 12px;}
div.cont{page-break-after: always;} 
 .pagenum:before { content: counter(page); }
</style>
<div class="header">
<table class="tablaFicha" border="0" style="margin-top: 0;width: 100%">
    <tr>
        <td width="25%">
            <img src="{{URL::asset('/images/gem_hztl.jpg')}}" width="180" />
        </td>
        <td style="text-align: center" width="50%">
            <p>Secretaría de Finanzas<br>
            Subsecretaría de Planeación y Presupuesto<br>
            Dirección General de Inversión</p>
        </td>
        <td width="25%">
            <img src="{{URL::asset('/images/logo-gente.png')}}" width="180" />
        </td>
    </tr>
</table>
</div>

{{-- {{dd($oficioAsignacion)}} --}}
@foreach ($relacion->expediente->contrato as $contrato)
    <div class="cont">
    <table class="content" style="float: right;width: 30%;">
        <tr>
            <td>FOLIO EXPEDIENTE TÉCNICO: {{$relacion->id_expediente_tecnico}}</td>
        </tr>
    </table>
    <div style="clear:both;"></div>
    <table class="content" style="width: 100%;">
        <tr>
            <td colspan="4" class="encabezado">DATOS DE LA AUTORIZACIÓN</td>
        </tr>
        <tr>
            <td colspan="4" ><p align="justify">NOMBRE DE LA OBRA Y/O ACCIÓN: {!! nl2br($relacion->obra->nombre) !!}</p></td>
        </tr>
        <tr>
            <td colspan="2">No. OFICIO: {{$oficioAsignacion[0]->clave}}</td>
            <td >FECHA DE OFICIO: {{$oficioAsignacion[0]->fecha_oficio}}</td>
            <td >INVERSIÓN ASIGNADA: ${{number_format($inversion,2)}}</td>
        </tr>
        <tr>
            <td>MUNICIPIO: {{$relacion->obra->municipio_reporte->nombre}}</td>
            <td>NÚMERO DE OBRA: {{$relacion->id_det_obra}}</td>
            <td colspan="2">FUENTE DE RECURSOS:
                @foreach ($oficioAsignacion as $value)
                    {{$value->descripcion}}, 
                @endforeach
             </td>
        </tr>
    </table>
    <table class="content" style="width: 100%;">
        <tr>
            <td colspan="2" class="encabezado">DATOS DE LA ADJUDICACIÓN</td>
        </tr>
        <tr>
            <td style="width: 170px;">TIPO DE ADJUDICACIÓN:</td>
            <td> {{$contrato->d_contrato->adjudicacion->modalidad}}</td>
        </tr>
    </table>

    <table class="content" style="width: 100%;">
        <tr>
            <td colspan="4" class="encabezado">DATOS GENERALES DEL CONTRATO</td>
        </tr>
        <tr>
            <td colspan="4"><p align="justify">NOMBRE O RAZÓN SOCIAL DEL CONTRATISTA: {{$contrato->empresa->nombre}}</p></td>
        </tr>
        <tr>
            <td colspan="2"><p align="justify">RFC: {{$contrato->empresa->rfc}}</p></td>
            <td colspan="2"><p align="justify">PADRÓN DEL CONTRATISTA: {{$contrato->empresa->padron_contratista}}</p></td>
        </tr>
        <tr>
            <td colspan="2"><p align="justify">NOMBRE DEL REPRESENTANTE: {{$contrato->empresa->nombre_representante}}</p></td>
            <td colspan="2"><p align="justify">CARGO: {{$contrato->empresa->cargo_representante}}</p></td>
        </tr>
        <tr>
            <td>No. DE CONTRATO: {{$contrato->numero_contrato}}</td>
            <td>IMPORTE DEL CONTRATO: ${{number_format($contrato->monto,2)}}</td>
            <td colspan="2">FECHA DEL CONTRATO: {{$contrato->fecha_celebracion}}</td>
        </tr>
        <tr>
            <td colspan="2">OBJETO DEL CONTRATO: {{$contrato->d_contrato->descripcion}}</td>
            <td>FECHA DE INICIO: {{$contrato->d_contrato->fecha_inicio}}</td>
            <td>FECHA DE TERMINO: {{$contrato->d_contrato->fecha_fin}}</td>
        </tr>
        <tr>
            <td>IMPORTE DEL ANTICIPO: ${{number_format($contrato->d_contrato->importe_anticipo,2)}}</td>
            <td>{{number_format($contrato->d_contrato->porcentaje_anticipo,2)}}%</td>
            <td colspan="2">FORMA DE PAGO: {{$contrato->d_contrato->forma_pago_anticipo}}</td>
        </tr>
        <tr>
            <td>DISPONIBILIDAD DE INMUEBLE: {{($contrato->d_contrato->bdisponibilidad_inmueble==1)? 'Si':'No'}}</td>
            <td colspan="2">MOTIVO: {{$contrato->d_contrato->motivo_no_disponible or '--'}}</td>
            <td>FECHA DE DISPONIBILIDAD: {{$contrato->d_contrato->fecha_disponibilidad or '--'}}</td>
        </tr>
        <tr>
            <td colspan="2">TIPO DE CONTRATO: {{$contrato->d_contrato->tipo_contrato->nombre}}</td>
            <td colspan="2">TIPO DE OBRA: {{$contrato->d_contrato->tipo_obra_contrato->nombre}}</td>
        </tr>
    </table>
       
    <table class="content" style="width: 100%;">
        <tr>
            <td colspan="2" class="encabezado">DATOS DE LAS FIANZAS</td>
        </tr>
        <tr>
            <td><p align="center">CUMPLIMIENTO</p></td>
            <td><p align="center">ANTICIPO</p></td>
        </tr>
        {{-- <tr>
            <td>AFIANZADORA: </td>
            <td>AFIANZADORA: </td>
        </tr> --}}
        <tr>
            <td>No. DE FIANZA: {{$contrato->d_contrato->folio_garantia_cumplimiento or '--'}}</td>
            <td>No. DE FIANZA: {{$contrato->d_contrato->folio_garantia or '--'}}</td>
        </tr>
        <tr>
            <td>IMPORTE AFIANZADO: ${{($contrato->d_contrato->importe_garantia_cumplimiento)? number_format($contrato->d_contrato->importe_garantia_cumplimiento,2) : '--'}}</td>
            <td>IMPORTE AFIANZADO: ${{($contrato->d_contrato->importe_garantia)? number_format($contrato->d_contrato->importe_garantia,2) : '--'}}</td>
        </tr>
        <tr>
            <td>VIGENCIA DE LA FIANZA: {{$contrato->d_contrato->fecha_inicio_garantia_cumplimiento or '--'}} AL {{$contrato->d_contrato->fecha_fin_garantia_cumplimiento or '--'}}</td>
            <td>VIGENCIA DE LA FIANZA: {{$contrato->d_contrato->fecha_inicio_garantia or '--'}} AL {{$contrato->d_contrato->fecha_fin_garantia or '--'}}</td>
        </tr>
        <tr>
            <td>FECHA: {{$contrato->d_contrato->fecha_emision_garantia_cumplimiento or '--'}}</td>
            <td>FECHA: {{$contrato->d_contrato->fecha_emision_garantia or '--'}}</td>
        </tr>
    </table>  
</div>
 {{-- {{dd($contrato)}} --}}
<div class="cont">
    <table class="content" cellpadding="3" style="width: 100%;">
    <thead>
        <tr>
        <td colspan="8" class="encabezado">CONCEPTOS DE TRABAJO</td>
    </tr>
    <tr class="punto">
        <td>Clave por objeto de gasto</td><td>Concepto</td><td>Unidad de Medida</td><td>Cantidad</td><td>Precio Unitario</td><td>Importe sin I.V.A.</td><td>I.V.A.</td><td>Total</td>
    </tr>
    </thead>
    <tbody>
         @foreach ($contrato->conceptos as $conceptos)
        @php
            $total_sin_iva+=$conceptos->importe;
            $total_iva+=$conceptos->iva;
            $total+=$conceptos->total;
        @endphp
    <tr>
       <td>
       {{$conceptos->clave_objeto_gasto}}</td><td>{{$conceptos->concepto}}</td><td>{{$conceptos->unidad_medida}}</td><td class="num">{{number_format($conceptos->cantidad, 2)}}</td><td class="num">${{number_format($conceptos->precio_unitario,2)}}</td><td class="num">${{number_format($conceptos->importe,2)}}</td><td class="num">${{number_format($conceptos->iva,2)}}</td><td class="num">${{number_format($conceptos->total,2)}}
       </td>
    </tr>  
    @endforeach
    </tbody>
   <tfoot>
       <tr>
        <td colspan="5" style="text-align: right">Total:</td>
        <td class="num">${{number_format($total_sin_iva,2)}}</td>
        <td class="num">${{number_format($total_iva,2)}}</td>
        <td class="num">${{number_format($total,2)}}</td>
    </tr>
   </tfoot>
</table>
</div>

<div class="cont">
    <table class="content" cellpadding="3" style="width: 100%;">
    <tr>
        <td colspan="14" class="encabezado">PROGRAMA DE OBRA O ACCIÓN DEL CONTRATO</td>
    </tr>
    <tr class="punto">
        <td rowspan="2" colspan="2">Principales Conceptos<br>de Trabajo</td><td colspan="12">Concepto</td>
    </tr>
    <tr class="punto" style="font-size: 90%;">    
        <td>ENE</td><td>FEB</td><td>MAR</td><td>ABR</td><td>MAY</td><td>JUN</td><td>JUL</td><td>AGO</td><td>SEP</td><td>OCT</td><td>NOV</td><td>DIC</td>                
    </tr>
     @foreach ($contrato->avance_fisico as $programa)
     <tr>
        <td colspan=2>{{$programa->concepto}}</td>
        <td class="num">{{$programa->porcentaje_enero}}%</td>
        <td class="num">{{$programa->porcentaje_febrero}}%</td>
        <td class="num">{{$programa->porcentaje_marzo}}%</td>
        <td class="num">{{$programa->porcentaje_abril}}%</td>
        <td class="num">{{$programa->porcentaje_mayo}}%</td>
        <td class="num">{{$programa->porcentaje_junio}}%</td>
        <td class="num">{{$programa->porcentaje_julio}}%</td>
        <td class="num">{{$programa->porcentaje_agosto}}%</td>
        <td class="num">{{$programa->porcentaje_septiembre}}%</td>
        <td class="num">{{$programa->porcentaje_octubre}}%</td>
        <td class="num">{{$programa->porcentaje_noviembre}}%</td>
        <td class="num">{{$programa->porcentaje_diciembre}}%</td>
     </tr>   
    @endforeach        
</table>
</div>

<div class="cont">
   <table class="content" cellpadding="3" style="width: 100%;">
    <tr><td colspan="4" class="encabezado">CALENDARIO DE MINISTRACIÓN DE RECURSOS</td></tr>
    <tr class="punto"><td>MES</td><td>MENSUAL</td><td>ACUMULADO</td><td>%</td></tr>
    @php
        $acumulado =0.00;
        $total_inversion = $contrato->monto;
        $porc=0;
        $i=0;
        $arrayMeses = Array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        for($i=0;$i<12;$i++){
            $acumulado += $contrato->avance_financiero->$arrayMeses[$i];
            $porc = ($acumulado*100)/$total_inversion;
            echo '<tr><td class="punto">'.strtoupper($arrayMeses[$i]).'</td><td style="text-align:right">$'.number_format($contrato->avance_financiero->$arrayMeses[$i],2).'</td><td style="text-align:right">$'.number_format($acumulado,2).'</td><td  class="num">'.round($porc).'%</td></tr>';
        }

    @endphp
           
</table> 
</div>
@endforeach
