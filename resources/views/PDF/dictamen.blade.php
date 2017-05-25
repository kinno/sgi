{{-- {{dd($estudio)}} --}}
<style>
.tablaFicha{
        width: 100%;
        font-size: 10px;        
    }
   .general {
		color: #000;
		font-family: times;
		font-size: 8pt;
		border: 1px solid rgb(200,200,200);
		background-color: #FFF;     
		width: 100%;          
	}    
	td {        
		background-color: #FFF;                
	}
	td.contenido {
		border: 1px solid rgb(200);
	}    
	th {
		background-color: rgb(230);
		border: 1px solid rgb(170);      
	}
	.divi {
	  background-color: #b0e0e6;   
	  position: absolute;   
	margin-left: auto;
	margin-right: auto;      
	   margin-left: 10px;
	}
  .center{ text-align: center; }
  .right { text-align: right; }
  .fila_0 { background-color: #FFF;}
  .fila_1 { background-color: rgb(240); }
  td.verde {
    background-color: #7DAB49;     
    }
    th.concepto {
        background-color: #BBBFBC;     
    }
    td.concepto {
        background-color: #BBBFBC; 
    }
    td.cuadro {
        background-color: #FFFFFF;
        border: 1px solid #000000;      
    }
    td.renglon {
        background-color: #E1E0E0;
    }
</style>
@php
	switch($estudio->id_tipo_evaluacion){
		case 1:
            $sTituloReporte = "DICTAMEN DE FICHA TÉCNICA";
            break;
        case 2:
            $sTituloReporte = "DICTAMEN DE ESTUDIO DE PRE-INVERSIÓN";
            break;
        case 3:
            $sTituloReporte = "DICTAMEN DE COSTO-BENEFICIO SIMPLIFICADO (NIVEL DE PERFIL)";
            break;
        case 4:
            $sTituloReporte = "DICTAMEN DE COSTO-BENEFICIO (NIVEL DE PREFACTIBILIDAD)";
            break;
        case 5:
            $sTituloReporte = "DICTAMEN DE COSTO-EFICIENCIA SIMPLIFICADO (NIVEL DE PERFIL)";
            break;
        case 6:
            $sTituloReporte = "DICTAMEN DE COSTO-EFICIENCIA (NIVEL DE PREFACTIBILIDAD)";
            break;
	}	
@endphp
<table class="tablaFicha" style="margin-top: 0">
    <tr>
        <td width="25%">
            <img src="{{URL::asset('/images/gem_hztl.jpg')}}" width="180" />
        </td>
        <td style="font-size: 10px; text-align: center" width="50%">
            <p>Secretaría de Finanzas<br>
            Subsecretaría de Planeación y Presupuesto<br>
            Dirección General de Inversión</p>
        </td>
        <td width="25%">
            <img src="{{URL::asset('/images/logo-gente.png')}}" width="180" />
        </td>
    </tr>
</table>
<h5 align="center">{{$sTituloReporte}}</h5>
<div style="margin-right: 0px; text-align: right">Número de dictamen: <b>{{$estudio->dictamen}}</b></div>
<div style="margin-right: 0px; text-align: right">Fecha de evaluación: <b>{{$estudio->movimientos[0]->fecha_movimiento}}</b></div>
<table cellspacing="0" cellpadding="2" border="0" class="general">
	<tr>
		<th>Nombre de la obra:</th>
		<td class="contenido">{{$estudio->hoja1->nombre_obra}}</td>
	</tr>
	<tr>
		<th>Descripción del proyecto:</th>
		<td class="contenido">{{$estudio->hoja1->principales_caracteristicas}}</td>
	</tr>
	<tr>
		<th>Sector:</th>
		<td class="contenido">
			{{$estudio->hoja1->sector->nombre}}
		</td>
	</tr>
	<tr>
		<th>Tipo de PPI:</th>
		<td class="contenido">{{$estudio->indicadores[0]->tipo_ppi->nombre}} </td>
	</tr>
	<tr>
	@php
		foreach ($estudio->fuentes_monto as $value) {
			if($value->tipo_fuente=="F"){
				echo '<th>Fuente de Financiamiento Federal</th><td class="contenido">'.number_format($value->pivot->monto,2).' '.$value->descripcion.'</td>';	
			}else{
				echo '<th>Fuente de Financiamiento Estatal</th><td class="contenido">'.number_format($value->pivot->monto,2).' '.$value->descripcion.'</td>';
			}
		}
	@endphp
	</tr>
	<tr>
		<th>Unidad Responsable:</th>
		<td class="contenido">
			{{$estudio->hoja1->unidad_ejecutora->nombre}}
		</td>
	</tr>
	<tr>
		<th>Observaciones generales:</th>
		<td class="contenido">{{$estudio->indicadores[0]->observaciones}}</td>
	</tr>
</table>
<br>
<h5 align="center">RESULTADO DEL DICTAMEN</h5>
<table class="general">
<tr>
	<th  align="left" ba class="concepto">&nbsp;&nbsp;&nbsp;CONCEPTO</th>
 	<th  class="concepto"></th>
</tr>
@php
	$tabla = "";
	foreach ($puntos as $value) {
		$tabla.= '<tr><td colspan="2" align="center" class="verde">'.$value->nombre.'</td></tr>';
		foreach ($value->inciso as $inciso) {
			$tabla.= '<tr>
			<td colspan="2" align="left" class="concepto">'.$inciso->etiqueta.' '.$inciso->nombre.'</td>         
			</tr>';
			$bandColor=false;
			foreach ($inciso->subinciso as $key => $subinciso) {
						if ($bandColor) {
		                $bRenglon = "renglon";
				        } else {
				            $bRenglon = "";
	        			}
	        			
	        			switch ($estudio->indicadores[0]->evaluaciones[$key]->brespuesta) {
	        				case 1:
	        					$resp="Si";
	        					break;
	        				case 3:
	        					$resp="N/A";
	        					break;
	        				default:
	        					# code...
	        					break;
	        			}
	        			
	        			if ( $subinciso->id !==36 && $subinciso->id !==37 && $subinciso->id !==38 && $subinciso->id !==39 && $subinciso->id !==40 && $subinciso->id !==41 && $subinciso->id !==42) {
	        				$tabla.='<tr>
								<td align="left" class="'.$bRenglon.'">'.$subinciso->etiqueta.' '.$subinciso->nombre.'</td>
								<td align="center" class="cuadro '.$bRenglon.'">'.$resp.'</td>
						       
							</tr>';
							$bandColor = !$bandColor;
	        				
	        			}
						
			}
		}
	}
	echo $tabla;
@endphp
</table>
<br><br>
<table class="general">
<tr>
<td colspan="2" class="verde" align="center">INDICADORES DE RENTABILIDAD</td>
</tr>
@if ($estudio->id_tipo_evaluacion==1 && ($estudio->hoja1->monto > "30000000" && $estudio->hoja1->monto < "50000000"))
	<tr>
		<td class="renglon">VAN:</td>
		<td class="renglon">$ {{number_format($estudio->indicadores[0]->van,2)}}</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==3 || $estudio->id_tipo_evaluacion==4)
	<tr>
		<td class="renglon">VAN o VPN:</td>
		<td class="renglon">$ {{number_format($estudio->indicadores[0]->van,2)}}</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==1 && ($estudio->hoja1->monto > "30000000" && $estudio->hoja1->monto < "50000000") || $estudio->id_tipo_evaluacion==3 || $estudio->id_tipo_evaluacion==4)
	<tr>
		<td >TIR:</td>
		<td > {{number_format($estudio->indicadores[0]->tir)}}%</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==1 && ($estudio->hoja1->monto > "30000000" && $estudio->hoja1->monto < "50000000") || $estudio->id_tipo_evaluacion==3 || $estudio->id_tipo_evaluacion==4)
	<tr>
		<td class="renglon">TRI:</td>
		<td class="renglon"> {{number_format($estudio->indicadores[0]->tri)}}%</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==1 && ($estudio->hoja1->monto > "30000000" && $estudio->hoja1->monto < "50000000"))
	<tr>
		<td >VAC Propuesta:</td>
		<td >$ {{number_format($estudio->indicadores[0]->vacpta,2)}}</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==5 || $estudio->id_tipo_evaluacion==6)
	<tr>
		<td class="concepto" align="left" colspan="2">Proyecto propuesto:</td>
	</tr>
	<tr>
		<td >VAC o VPC:</td>
		<td >$ {{number_format($estudio->indicadores[0]->vacpta,2)}}</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==1 && ($estudio->hoja1->monto > "30000000" && $estudio->hoja1->monto < "50000000"))
	<tr>
		<td class="renglon">CAE Propuesta:</td>
		<td class="renglon">$ {{number_format($estudio->indicadores[0]->caepta,2)}}</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==5 || $estudio->id_tipo_evaluacion==6)
	<tr>
		<td class="renglon">CAE:</td>
		<td class="renglon">$ {{number_format($estudio->indicadores[0]->vacpta)}}</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==1 && ($estudio->hoja1->monto > "30000000" && $estudio->hoja1->monto < "50000000"))
	<tr>
		<td >VAC Alternativa:</td>
		<td >$ {{number_format($estudio->indicadores[0]->vacalt,2)}}</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==5 || $estudio->id_tipo_evaluacion==6)
	<tr>
		<td class="concepto" align="left" colspan="2">Alternativa:</td>
	</tr>
	<tr>
		<td >VAC o VPC:</td>
		<td >$ {{number_format($estudio->indicadores[0]->vacalt,2)}}</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==1 && ($estudio->hoja1->monto > "30000000" && $estudio->hoja1->monto < "50000000"))
	<tr>
		<td class="renglon">CAE Alternativa:</td>
		<td class="renglon">$ {{number_format($estudio->indicadores[0]->caealt,2)}}</td>
	</tr>
@endif
@if ($estudio->id_tipo_evaluacion==5 || $estudio->id_tipo_evaluacion==6)
	<tr>
		<td >CAE:</td>
		<td >$ {{number_format($estudio->indicadores[0]->caealt,2)}}</td>
	</tr>
@endif

</table>
{{-- {{dd($puntos)}} --}}

