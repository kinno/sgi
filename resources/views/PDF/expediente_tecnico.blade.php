
@php
    $objeto_obra="";
   
    if ($relacion->expediente->hoja1->bestudio_socioeconomico== 1) {
            $objeto_obra.="Estudio Socioeconómico, ";
    }
    if ($relacion->expediente->hoja1->bderecho_via== 1) {
        $objeto_obra.="Liberación del Derecho de Vía, ";
    }
    if ($relacion->expediente->hoja1->bimpacto_ambiental== 1) {
        $objeto_obra.="Manifestación del Impacto Ambiental, ";
    }
    if ($relacion->expediente->hoja1->bobra == 1) {
        $objeto_obra.="Obra, ";
    }
    if ($relacion->expediente->hoja1->baccion== 1) {
        $objeto_obra.="Acción, ";
    }
    if ($relacion->expediente->hoja1->botro== 1) {
        $objeto_obra.="Otro: " . $relacion->expediente->hoja1->descripcion_botro . ",";
    }
    $clave_acuerdo = "";
    $nombre_acuerdo = "";
    foreach ($relacion->expediente->acuerdos as $acuerdo) {
        $clave_acuerdo .= $acuerdo["clave"] . "<br>";
        $nombre_acuerdo .= $acuerdo["nombre"] . "<br>";
    }
    $total_inversion=0.00;
    $monto_federal = "";
    $fuente_federal = "";
    $monto_estatal = "";
    $fuente_estatal = "";
    foreach ($relacion->expediente->fuentes_monto as $fuentes) {
        if($fuentes->tipo == "F"){
            $monto_federal .= "$".number_format($fuentes->pivot->monto, 2) . "<br>";
            $total_inversion +=$fuentes->pivot->monto;
            $fuente_federal .= $fuentes->descripcion . "<br>";
        }else if($fuentes->tipo=="E"){
            $monto_estatal .= "$".number_format($fuentes->pivot->monto, 2) . "<br>";
            $total_inversion +=$fuentes->pivot->monto;
            $fuente_estatal .= $fuentes->descripcion . "<br>";
        }
        
    }
    $total_sin_iva =0;
    $total_iva =0;
    $total =0;
@endphp
<style>
    table.content td{border: #000 1px solid;}
    table tfoot{bottom: 0px;}
    .encabezado{background-color: #7DAB49; text-align: center; border-color: #7DAB49; font-weight: bold;}
    .punto{text-align: center; font-weight: bold; background-color: #EEEEEE;}
    .num{text-align: right;}
    .c{text-align: center;}
    .j{text-align: justify;}
    div.breakNow { page-break-before:avoid; page-break-after:always; }
    div.header { width: 100%;height:10%; top: 0px;}
    div.cont { height: 89% ; border: #c4c4c4 1px solid; page-break-after: always; font-size: 12px !important;}
    div.foot { width: 100%;height:1% ;bottom: 0px;  position: fixed;}
    table {font-size: 12px;}
    div.cont{ }
     .pagenum:before { content: counter(page); }
</style>
{{-- {{dd($relacion)}} --}}
{{-- ANEZXO 1 --}}
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
<div class="foot" style="text-align: right">Página: <span class="pagenum"></span></div>
<div class="cont">
   <table class="content" cellpadding="5" style="width: 100%;">
    <tr>
        <td colspan="3" style="border: none;"></td>
        <td class="punto">Expediente Técnico</td>
        <td class="num">{{$relacion->id_expediente_tecnico}}</td>
    </tr>
    <tr>
        <td colspan="5" class="encabezado"><strong>Tipo de Tr&aacute;mite</strong></td>
    </tr>
    <tr>
        <td  colspan="2" class="punto">Solicitud de Presupuesto</td><td colspan="3" class="punto">Objeto</td>
    </tr>
    <tr class="c">
        <td colspan="2">{{$relacion->expediente->tipoSolicitud->nombre}}</td><td colspan="3">{{$objeto_obra}}</td>
    </tr>
    <tr>
        <td class="punto">Clave</td><td colspan="4" class="punto">Unidad Ejecutora</td>
    </tr>
    <tr class="c">
        <td>{{$relacion->expediente->hoja1->unidad_ejecutora->clave}}</td><td colspan="4">{{$relacion->expediente->hoja1->unidad_ejecutora->nombre}}</td>
    </tr>
    <tr>
        <td class="punto">Clave</td><td colspan="4" class="punto">Dependencia Responsable</td>
    </tr>
    <tr class="c">
        <td>%Clave</td><td colspan="4">{$array["psolicitud"][0]["NomSec"]}</td>
    </tr>
     <tr >
         <td colspan="5" class="punto">Acci&oacute;n de Gobierno</td>
    </tr>
     <tr>
         <td class="punto">N&uacute;mero</td><td colspan="4" class="punto">Descripci&oacute;n</td>
    </tr>
    
    @foreach ($relacion->expediente->acuerdos as $acuerdo)
       <tr> <td>{{$acuerdo->clave}}</td><td colspan="4" class="j">{{$acuerdo->nombre}}</td></tr>
    @endforeach
    <tr>
        <td class="punto">No. de Obra</td><td colspan="4" class="punto">Nombre de la Obra</td>
    </tr>
    <tr>
        <td class="num">@if ($relacion->obra){{$relacion->obra->id_obra}}@endif</td><td colspan="4" class="j">{{$relacion->expediente->hoja1->nombre_obra}}</td>
    </tr>
     <tr>
        <td colspan="2" class="punto">Monto Federal</td><td colspan="3" class="punto">Fuente de Financiamiento</td>
    </tr>
     <tr>

        <td colspan="2" class="num">@php echo $monto_federal;@endphp</td><td colspan="3">@php echo $fuente_federal;@endphp</td>
    </tr>
     <tr>
        <td colspan="2" class="punto">Monto Estatal</td><td colspan="3" class="punto">Fuente de Financiamiento</td>
    </tr>
     <tr>
        <td colspan="2" class="num">@php echo $monto_estatal;@endphp</td><td colspan="3">@php echo $fuente_estatal;@endphp</td>
    </tr>
     <tr>
        <td colspan="2" class="punto">Monto Municipal</td><td colspan="3" class="punto">Fuente de Financiamiento</td>
    </tr>
     <tr>
        <td colspan="2" class="num">{{$relacion->expediente->hoja1->monto_municipal}}</td><td colspan="3">{{$relacion->expediente->hoja1->fuente_municipal}}</td>
    </tr>
     <tr>
         <td colspan="2" class="punto">Modalidad de Ejecuci&oacute;n</td><td colspan="3" class="punto">Tipo de Obra</td>
    </tr>
     <tr class="c">
        <td colspan="2">@if ($relacion->expediente->hoja1->id_modalidad_ejecucion==1)Contrato @elseif ($relacion->expediente->hoja1->id_modalidad_ejecucion==2) Administración @endif </td><td colspan="3">@if ($relacion->expediente->hoja1->id_tipo_obra==1)Nueva @elseif ($relacion->expediente->hoja1->id_tipo_obra==2)En Proceso @endif</td>
    </tr>
    <tr >
        <td colspan="5" class="punto">Descripci&oacute;n Detallada de la Obra</td>
    </tr>
    <tr class="j">
        <td colspan="5">{{$relacion->expediente->hoja1->principales_caracteristicas}}</td>
    </tr>
    <tr >
        <td colspan="5" class="punto">Justificaci&oacute;n de la Obra</td>
    </tr>
    <tr class="j">
        <td colspan="5">{{$relacion->expediente->hoja1->justificacion_obra}}</td>
    </tr>
    <tr >
        <td colspan="5" class="encabezado">Documentos Soporte</td>
    </tr>
     <tr>
         <td colspan="2" class="punto">Estudio Socioecon&oacute;mico</td><td colspan="3" class="punto">Proyecci&oacute;n e Impacto de la Obra</td>
    </tr>
     <tr>
         <td colspan="2" rowspan="2">{{$relacion->expediente->id_estudio_socioeconomico}}</td><td class="punto">Beneficiarios</td><td class="punto">Unidad de Medida</td><td class="punto">Cantidad</td>
    </tr>
     <tr class="c">
         <td>{{$relacion->expediente->hoja1->beneficiario->nombre}}</td><td>{{$relacion->expediente->hoja1->beneficiario->nombre}}</td><td class="num">{{$relacion->expediente->hoja1->cantidad_beneficiario}}</td>
    </tr>
</table> 
</div>


{{-- <div class="breakNow"></div> --}}
{{-- ANEXO 2 --}}
<div class="cont">
  <table class="content" style="width: 100%" cellpadding="3">
    <tr>
        <td colspan="5" class="encabezado">Localizaci&oacute;n de la Obra</td>
    </tr>
    <tr class="punto">
        <td colspan="2">Tipo de Cobertura</td><td colspan="3">Municipio(s) o Region(es)</td>
    </tr>
    <tr>
        <td colspan="2" class="c">{{$relacion->expediente->hoja2->cobertura->nombre}}</td>
        <td colspan="3" class="j">
                @foreach ($relacion->expediente->regiones as $regiones)
                    {{$regiones->nombre}},
                @endforeach
                @foreach ($relacion->expediente->municipios as $municipios)
                     {{$municipios->nombre}},   
                @endforeach
        </td>
    </tr>
   
    <tr class="punto">
        <td colspan="4">Localidad(es)</td><td>Tipo de Localidad</td>
    </tr>
    <tr>
        <td colspan="4" class="j">{{$relacion->expediente->hoja2->nombre_localidad}}</td><td class="c">{{$relacion->expediente->hoja2->localidad->nombre}}
        </td>
    </tr>
    <tr class="punto">
       <td colspan="5">Coordenadas</td>
    </tr>
    <tr>
       <td colspan="5">
       @if ($relacion->expediente->hoja2->bcoordenadas==1)
           Latitud Inicial: {{$relacion->expediente->hoja2->latitud_inicial}} Longitud Inicial: {{$relacion->expediente->hoja2->longitud_inicial}}<br>Latitud Final: {{$relacion->expediente->hoja2->latitu_final}} Longitud Final: {{$relacion->expediente->hoja2->longitud_final}}
       @endif
            {{$relacion->expediente->hoja2->observaciones_coordenadas}}
       </td>
    </tr>
    <tr class="punto">
       <td colspan="5">Microlocalizaci&oacute;n de la Obra</td>
    </tr>
    <tr>
       <td colspan="5">
       @if ($relacion->expediente->hoja2->microlocalizacion)
           <center><img src="{{ asset('/uploads/')."/".$relacion->expediente->hoja2->microlocalizacion }}" style="width:400;" ></center>
       @endif
       </td>
    </tr>
</table>  
</div>


{{-- <div class="breakNow"></div> --}}
{{-- ANEXO 3 --}}
<div class="cont">
    <table class="content" cellpadding="3" style="width: 100%;">
    <thead>
        <tr>
        <td colspan="8" class="encabezado">Presupuesto de la Obra o Acci&oacute;n</td>
    </tr>
    <tr class="punto">
        <td>Clave por objeto de gasto</td><td>Concepto</td><td>Unidad de Medida</td><td>Cantidad</td><td>Precio Unitario</td><td>Importe sin I.V.A.</td><td>I.V.A.</td><td>Total</td>
    </tr>
    </thead>
    <tbody>
         @foreach ($relacion->expediente->conceptos as $conceptos)
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


{{-- <div class="breakNow"></div> --}}
{{-- ANEXO 4 --}}
<div class="cont">
    <table class="content" cellpadding="3" style="width: 100%;">
    <tr>
        <td colspan="14" class="encabezado">Programa de Obra o Acci&oacute;n</td>
    </tr>
    <tr class="punto">
        <td rowspan="2" colspan="2">Principales Conceptos<br>de Trabajo</td><td colspan="12">Concepto</td>
    </tr>
    <tr class="punto" style="font-size: 90%;">    
        <td>ENE</td><td>FEB</td><td>MAR</td><td>ABR</td><td>MAY</td><td>JUN</td><td>JUL</td><td>AGO</td><td>SEP</td><td>OCT</td><td>NOV</td><td>DIC</td>                
    </tr>
     @foreach ($relacion->expediente->programas as $programa)
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

{{-- <div class="breakNow"></div> --}}
<div class="cont">
   <table class="content" cellpadding="3" style="width: 100%;">
    <tr><td colspan="4" class="encabezado">Calendario de Ministraci&oacute;n de Recursos</td></tr>
    <tr class="punto"><td>MES</td><td>MENSUAL</td><td>ACUMULADO</td><td>%</td></tr>
    @php
        $acumulado =0.00;
        $porc=0;
        $i=0;
        $arrayMeses = Array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        for($i=0;$i<12;$i++){
            $acumulado += $relacion->expediente->avance_financiero->$arrayMeses[$i];
            $porc = ($acumulado*100)/$total_inversion;
            echo '<tr><td class="punto">'.strtoupper($arrayMeses[$i]).'</td><td style="text-align:right">$'.number_format($relacion->expediente->avance_financiero->$arrayMeses[$i],2).'</td><td style="text-align:right">$'.number_format($acumulado,2).'</td><td  class="num">'.$porc.'%</td></tr>';
        }

    @endphp
           
</table> 
</div>

{{-- <div class="breakNow"></div> --}}
{{-- ANEXO 5 --}}
<div class="cont">
   <table class="content" cellpadding="3" style="width: 100%;">
    <tr>
        <td class="encabezado">Observaciones de la Dependencia y/o Unidad Ejecutora</td>
    </tr>
    <tr>
    @if ($relacion->expediente->hoja5)
        <td class="j">{!!nl2br(e($relacion->expediente->hoja5->observaciones_unidad_ejecutora))!!}</td>
    @else
        <td></td>    
    @endif
    </tr>
</table>   
</div>
 
{{-- <div class="breakNow"></div> --}}
{{-- ANEXO 6 --}}
<div >
    <table cellpadding="3" style="width: 100%;">
    <tr>
        <td class="punto">Unidad Ejecutora Normativa</td>
    </tr>
    <tr class="j">
        @if ($relacion->expediente->hoja6)
           <td> {{$relacion->expediente->hoja6->unidad_ejecutora_normativa}} </td>
        @else
            <td></td>  
        @endif
    </tr>
{{-- </table>    
<br><br>        
<table cellpadding="3" style="width: 100%;"> --}}
    <tr>
        <td class="punto">Criterios Sociales</td>
    </tr>
    <tr class="j">
        @if ($relacion->expediente->hoja6)
            <td> {!! nl2br($relacion->expediente->hoja6->criterios_sociales)!!} </td>
        @else
            <td></td>  
        @endif
       
    </tr>
</table>
</div>
