{{-- <pre>{{dd($estudio)}}</pre> --}}
<style>
    .tablaFicha{
        width: 100%;
        font-size: 10px;        
    }
    .celdaTablaFicha{
        border: 1px solid #CCCCCC;
        vertical-align: middle;
    }
    .fecha{
        text-align: right;
    }
    .encabezado{
        background-color: #EFEFEF;
    }
</style>
<table class="tablaFicha" border="0" style="margin-top: 0">
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

<h5 align="center">FICHA DE INGRESO A BANCO DE PROYECTOS</h5>
<table cellpadding="5" class="tablaFicha">
    <tr>
        <td class="fecha" colspan="6">
            FECHA DE REGISTRO:
        </td>
        <td class="celdaTablaFicha">
            {{$estudio->fecha_registro}}
        </td>
    </tr>
    <tr>
        <td class="celdaTablaFicha encabezado">
            NOMBRE DEL PROYECTO:
        </td>
        <td class="celdaTablaFicha" colspan="6">
            {{$estudio->hoja1->nombre_obra}}
        </td>
    </tr>
    <tr>
        <td class="celdaTablaFicha encabezado">
            SECTOR:
        </td>
        <td class="celdaTablaFicha" colspan="6">
            {{$estudio->hoja1->sector->nombre}}
        </td>
    </tr>
    <tr>
        <td class="celdaTablaFicha encabezado">
            UNIDAD EJECUTORA:
        </td>
        <td class="celdaTablaFicha" colspan="6">
            {{$estudio->hoja1->unidad_ejecutora->nombre}}
        </td>
    </tr>
    <tr>
        <td class="celdaTablaFicha encabezado">
            OBJETIVO DEL PROYECTO:
        </td>
        <td class="celdaTablaFicha" colspan="6">
            {{$estudio->hoja1->justificacion_obra}}
        </td>
    </tr>
    <tr>
        <td class="celdaTablaFicha encabezado" colspan="2">
            VIDA ÚTIL DEL PROYECTO:
        </td>
        <td class="celdaTablaFicha">
            {{$estudio->hoja1->vida_proyecto}} AÑOS
        </td>
        <td class="celdaTablaFicha encabezado" colspan="2">
            MONTO TOTAL DE INVERSIÓN:
        </td>
        <td class="celdaTablaFicha" colspan="2">
            ${{number_format($estudio->hoja1->monto)}}
        </td>
    </tr>
    <tr>
        <td class="celdaTablaFicha encabezado">
            COBERTURA:
        </td>
        <td class="celdaTablaFicha">
        @php
            switch ($estudio->hoja2->id_cobertura) {
                case 1:
                    echo "ESTATAL";
                    break; 
                case 2:
                    echo "REGIONAL";
                    break;
                case 3:
                    echo "MUNICIPAL";
                    break;
            }
        @endphp
            {{-- {{$estudio->hoja2->id_cobertura}} --}}
        </td>
        @if ($estudio->hoja2->id_cobertura==2)
        <td class="celdaTablaFicha encabezado">
            REGIONES:
        </td>
        <td class="celdaTablaFicha" colspan="4">
            @foreach ($estudio->regiones as $region)
            {{-- @foreach ($region->Cat_Region as $value) --}}
                {{$region->clave}} {{$region->nombre}},
            {{-- @endforeach --}}
        @endforeach
        </td>
        @elseif ($estudio->hoja2->id_cobertura==3)
        <td class="celdaTablaFicha' encabezado">
            MUNICIPIOS:
        </td>
        <td class="celdaTablaFicha" colspan="4">
            @foreach ($estudio->municipios as $municipio)
             {{-- @foreach ($municipio->Cat_Municipio as $value) --}}
                {{$municipio->nombre}}, 
            {{-- @endforeach --}}
        @endforeach
        </td>
        @else
        @endif
    </tr>
    @if($estudio->hoja2->nombre_localidad!=="")
    <tr>
        <td class="celdaTablaFicha encabezado">
            LOCALIDAD:
        </td>
        <td class="celdaTablaFicha" colspan="6">
            {{$estudio->hoja2->nombre_localidad}}
        </td>
    </tr>
    @endif
    <tr>
        <td class="celdaTablaFicha encabezado">
            DESCRIPCIÓN DEL PROYECTO:
        </td>
        <td class="celdaTablaFicha" colspan="6">
            {{$estudio->hoja1->principales_caracteristicas}}
        </td>
    </tr>
    @if (isset($acuerdos_federales)&&count($acuerdos_federales)>0)
    <tr>
        <td class="celdaTablaFicha encabezado" colspan="2">
            ACCIONES DE GOBIERNO FEDERAL:
        </td>
        <td class="celdaTablaFicha" colspan="5">
            @foreach ($acuerdos_federales as $element)
    
    {{$element->clave}} {{$element->nombre}},
    
    @endforeach
        </td>
    </tr>
    @endif
    @if (isset($acuerdos_estatales)&&count($acuerdos_estatales)>0)
    <tr>
        <td class="celdaTablaFicha encabezado" colspan="2">
            ACCIONES DE GOBIERNO ESTATAL:
        </td>
        <td class="celdaTablaFicha" colspan="5">
            @foreach ($acuerdos_estatales as $element)
    
    {{$element->clave}} {{$element->nombre}},
    
    @endforeach
        </td>
    </tr>
    @endif
    
@if ($estudio->hoja2->bcoordenadas==1)
    @if ($estudio->hoja2->latitud_final!==0)
    <tr>
        <td class="celdaTablaFicha encabezado" colspan="2" rowspan="2">
            UBICACIÓN DEL PROYECTO:
        </td>
        <td class="celdaTablaFicha encabezado">
            LATITUD:
        </td>
        <td class="celdaTablaFicha">
            {{$estudio->hoja2->latitud_inicial}}
        </td>
        <td class="celdaTablaFicha encabezado" colspan="2">
            LONGITUD:
        </td>
        <td class="celdaTablaFicha">
            {{$estudio->hoja2->longitud_inicial}}
        </td>
    </tr>
    <tr>
        <td class="celdaTablaFicha encabezado">
            LATITUD FINAL:
        </td>
        <td class="celdaTablaFicha">
            {{$estudio->hoja2->latitud_final}}
        </td>
        <td class="celdaTablaFicha encabezado" colspan="2">
            LONGITUD FINAL:
        </td>
        <td class="celdaTablaFicha">
            {{$estudio->hoja2->longitud_final}}
        </td>
    </tr>
    @else
    <tr>
        <td class="celdaTablaFicha encabezado" colspan="2" rowspan="2">
            UBICACIÓN DEL PROYECTO:
        </td>
        <td class="celdaTablaFicha encabezado">
            LATITUD:
        </td>
        <td class="celdaTablaFicha">
            {{$estudio->hoja2->latitud_inicial}}
        </td>
        <td class="celdaTablaFicha encabezado" colspan="2">
            LONGITUD:
        </td>
        <td class="celdaTablaFicha">
            {{$estudio->hoja2->longitud_inicial}}
        </td>
    </tr>
    @endif

@else
    <tr>
        <td class="celdaTablaFicha encabezado" colspan="2">
            UBICACIÓN DEL PROYECTO
        </td>
        <td class="celdaTablaFicha" colspan="5">
            {{$estudio->hoja2->observaciones_coordenadas}}
        </td>
    </tr>
    @endif
    <tr>
        <td class="celdaTablaFicha encabezado" colspan="3">
            TIEMPO ESTIMADO DE DESARROLLO:
        </td>
        <td class="celdaTablaFicha" colspan="2">
            {{$estudio->hoja1->duracion_anios}} AÑOS
        </td>
        <td class="celdaTablaFicha" colspan="3">
            {{$estudio->hoja1->duracion_meses}} MESES
        </td>
    </tr>
    <tr>
        <td class="celdaTablaFicha encabezado">
            BENEFICIADOS:
        </td>
        <td class="celdaTablaFicha encabezado" colspan="2">
            UNIDAD DE MEDIDA:
        </td>
        <td class="celdaTablaFicha" colspan="2">
            {{$estudio->hoja1->id_beneficiario}}
        </td>
        <td class="celdaTablaFicha encabezado">
            CANTIDAD:
        </td>
        <td class="celdaTablaFicha">
            {{$estudio->hoja1->cantidad_beneficiario}}
        </td>
    </tr>
    <tr>
        <td class="celdaTablaFicha encabezado">
            METAS:
        </td>
        <td class="celdaTablaFicha encabezado" colspan="2">
            UNIDAD DE MEDIDA:
        </td>
        <td class="celdaTablaFicha" colspan="2">
            {{$estudio->hoja1->id_meta}}
        </td>
        <td class="celdaTablaFicha encabezado">
            CANTIDAD:
        </td>
        <td class="celdaTablaFicha">
            {{$estudio->hoja1->cantidad_meta}}
        </td>
    </tr>
    @php
        $contadorFederal = 1;
        $contadorEstatal = 1;
        $numRowsFed=0;
        $numRowsEst=0;
        $bndFederal = true;
        $bndEstatal = true;
        $tabla="";
        for ($i = 0; $i < count($estudio->fuentes_monto); $i++) {
                if ($estudio->fuentes_monto[$i]['tipo_fuente'] === "F") {
                    $numRowsFed = $numRowsFed + 1;
                }
                if ($estudio->fuentes_monto[$i]['tipo_fuente'] === "E" ) {
                    $numRowsEst = $numRowsEst + 1;
                }
            }
        foreach ($estudio->fuentes_monto as $value) {
            if ($value->pivot->tipo_fuente === "F" && $bndFederal) {
                    $tabla = "<tr >
                                <td class=\"celdaTablaFicha encabezado\" rowspan=\"" . $numRowsFed . "\">FUENTES FEDERALES:</td>  
                                <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
                                <td class=\"celdaTablaFicha\">" .$value->descripcion. "</td>        
                                <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
                                <td class=\"celdaTablaFicha\">$" . number_format($value->pivot->monto, 2) . "</td>        
                                <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
                                <td class=\"celdaTablaFicha\">%</td>        
                            </tr>";
                            $bndFederal = false;
                }else if ($value->pivot->tipo_fuente === "F" && !$bndFederal) {
                    $tabla.="<tr nobr=\"true\">          
                                <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
                                <td class=\"celdaTablaFicha\">" . $value->descripcion . "</td>        
                                <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
                                <td class=\"celdaTablaFicha\">$" . number_format($value->pivot->monto, 2) . "</td>        
                                <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
                                <td class=\"celdaTablaFicha\">%</td>       
                            </tr>";
                  $contadorFederal++;          
                }
                $tabla = str_replace("numRowsFed", $contadorFederal, $tabla);
                if ($value->pivot->tipo_fuente === "E" && $bndEstatal) {
                    $tabla .="<tr nobr=\"true\">
                                <td class=\"celdaTablaFicha encabezado\" rowspan=\"" . $numRowsFed . "\">FUENTES ESTATALES:</td>  
                                <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
                                <td class=\"celdaTablaFicha\">" . $value->descripcion. "</td>        
                                <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
                                <td class=\"celdaTablaFicha\">$" . number_format($value->pivot->monto, 2) . "</td>        
                                <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
                                <td class=\"celdaTablaFicha\">%</td>        
                            </tr>";
                            $bndEstatal = false;
                }else if ($value->pivot->tipo_fuente  === "E" && !$bndEstatal) {
                    $tabla.="<tr nobr=\"true\">          
                                <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
                                <td class=\"celdaTablaFicha\">" . $value->descripcion . "</td>        
                                <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
                                <td class=\"celdaTablaFicha\">$" . number_format($value->pivot->monto, 2) . "</td>        
                                <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
                                <td class=\"celdaTablaFicha\">%</td>       
                            </tr>";
                  $contadorEstatal++;          
                }
                $tabla = str_replace("numRowsEst", $contadorEstatal, $tabla);
        }
        echo $tabla;


         // for ($i = 0; $i < count($estudio->fuentes_monto); $i++) {
         //        if ($estudio->fuentes_monto[$i]['tipo_fuente'] === "F" && $bndFederal) {
         //            $tabla = "<tr >
         //                        <td class=\"celdaTablaFicha encabezado\" rowspan=\"" . $numRowsFed . "\">FUENTES FEDERALES:</td>  
         //                        <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
         //                        <td class=\"celdaTablaFicha\">" . $estudio->fuentes_monto[$i]['detalle_fuentes'][0]['descripcion']. "</td>        
         //                        <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
         //                        <td class=\"celdaTablaFicha\">$" . number_format($estudio->fuentes_monto[$i]['monto'], 2) . "</td>        
         //                        <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
         //                        <td class=\"celdaTablaFicha\">%</td>        
         //                    </tr>";
         //                    $bndFederal = false;
         //        }else if ($estudio->fuentes_monto[$i]['tipo_fuente'] === "F" && !$bndFederal) {
         //            $tabla.="<tr nobr=\"true\">          
         //                        <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
         //                        <td class=\"celdaTablaFicha\">" . $estudio->fuentes_monto[$i]['detalle_fuentes'][0]['descripcion'] . "</td>        
         //                        <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
         //                        <td class=\"celdaTablaFicha\">$" . number_format($estudio->fuentes_monto[$i]['monto'], 2) . "</td>        
         //                        <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
         //                        <td class=\"celdaTablaFicha\">%</td>       
         //                    </tr>";
         //          $contadorFederal++;          
         //        }
         //        $tabla = str_replace("numRowsFed", $contadorFederal, $tabla);
         //        if ($estudio->fuentes_monto[$i]['tipo_fuente'] === "E" && $bndEstatal) {
         //            $tabla .="<tr nobr=\"true\">
         //                        <td class=\"celdaTablaFicha encabezado\" rowspan=\"" . $numRowsFed . "\">FUENTES ESTATALES:</td>  
         //                        <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
         //                        <td class=\"celdaTablaFicha\">" . $estudio->fuentes_monto[$i]['detalle_fuentes'][0]['descripcion']. "</td>        
         //                        <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
         //                        <td class=\"celdaTablaFicha\">$" . number_format($estudio->fuentes_monto[$i]['monto'], 2) . "</td>        
         //                        <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
         //                        <td class=\"celdaTablaFicha\">%</td>        
         //                    </tr>";
         //                    $bndEstatal = false;
         //        }else if ($estudio->fuentes_monto[$i]['tipo_fuente'] === "E" && !$bndEstatal) {
         //            $tabla.="<tr nobr=\"true\">          
         //                        <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
         //                        <td class=\"celdaTablaFicha\">" . $estudio->fuentes_monto[$i]['detalle_fuentes'][0]['descripcion'] . "</td>        
         //                        <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
         //                        <td class=\"celdaTablaFicha\">$" . number_format($estudio->fuentes_monto[$i]['monto'], 2) . "</td>        
         //                        <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
         //                        <td class=\"celdaTablaFicha\">%</td>       
         //                    </tr>";
         //          $contadorEstatal++;          
         //        }
         //        $tabla = str_replace("numRowsEst", $contadorEstatal, $tabla);
         //        // if ($estudio->fuentes_monto[$i]['tipo_fuente'] === "E" ) {
         //        //     $numRowsEst = $numRowsEst + 1;
         //        // }
         //    }
         //    echo $tabla;    
    @endphp
    @if ($estudio->hoja1->fuente_municipal)
        <tr>
            <td class="celdaTablaFicha encabezado">FUENTE MUNICIPAL:</td>
            <td class="celdaTablaFicha encabezado">NOMBRE:</td>
            <td class="celdaTablaFicha">{{$estudio->hoja1->fuente_municipal}}</td>
            <td class="celdaTablaFicha encabezado">MONTO:</td>
            <td class="celdaTablaFicha">{{number_format($estudio->hoja1->monto_municipal,2)}}</td>
        </tr>
    @endif
    @php
    $tabla="";
        //factibilidad Legal
$varFL = 0;
$fL = "";
$jdFL = $estudio->hoja1->jfactibilidad_legal;
$objFL = json_decode($jdFL, true);
$arrayFL = array(
    "fl_cu_libder" => "Liberación de Derecho de Vía",
    "fl_cu_libter" => "Liberación del Terreno (libre de gravamen)",
    "fl_cu_cfe" => "Permisos de CFE",
    "fl_cu_telmex" => "Permisos de TELMEX",
    "fl_cu_pemex" => "Permisos de PEMEX",
    "fl_cu_inah" => "Permisos del INAH",
    "fl_cu_inba" => "Permisos del INBA",
    "fl_cu_sep" => "Autorizaci&oacute;n de la SEP",
    "fl_cu_isem" => "Permisos del ISEM",
    "fl_cu_conagua" => "Permisos de CONAGUA",
    "fl_cu_marcas" => "Registro de Marcas",
    "fl_cu_producto" => "Uso del Producto",
    "fl_cu_caem" => "Permisos de CAEM",
    "fl_cu_jc" => "Permisos de la JC",
    "fl_cu_autmun" => "Permisos de la Autoridad Municipal",
);
foreach ($objFL as $key => $value) {
    foreach ($value as $key2 => $data) {
        reset($data);
        while (list($clave, $valor) = each($data)) {
            if ($valor == 1) {
                $varFL++;
                $fL .= $arrayFL["$clave"] . ", ";
            }
        }
    }
}
if ($varFL > 0) {
    $tabla .= "<tr nobr=\"true\">
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">FACTIBILIDAD LEGAL:</td>  
        <td class=\"celdaTablaFicha\" colspan=\"5\">";
    $fL = trim($fL, ", ");
    $tabla .= $fL . "</td>";
    $tabla .= "</tr>";
}
//factibilidad Ambiental
$varFA1 = 0;
$varFA2 = 0;
$varFA3 = 0;
$fA1 = "";
$fA2 = "";
$fA3 = "";
$jdFA = $estudio->hoja1->jfactibilidad_ambiental;
$objFA = json_decode($jdFA, true);
$arrayFA = array(
    "fa_us_moda" => "Trámite Unificado de Cambio de Uso de Suelo Forestal. Modalidad A",
    "fa_us_solautcu" => "Solicitud de Autorización de Cambio de Uso de Suelo en Terrenos Forestales:",
    "fa_ia_miariesgo" => "MIA con riesgo",
    "fa_ia_miapart" => "MIA Particular",
    "fa_ia_miapr" => "MIA Particular con Riesgo",
    "fa_ia_infpre" => "Informe Preventivo",
    "fa_ia_camb" => "Certificación Ambiental",
    "fa_ea_aamia" => "Liberación de Derecho de Vía",
    "fa_ea_actamia" => "Liberación del Terreno (libre de gravamen)",
    "fa_ea_anramia" => "Permisos de CFE",
    "fa_ea_sepmia" => "Permisos de TELMEX",
    "fa_ea_mpamia" => "Permisos de PEMEX",
    "fa_ea_pcca" => "Permisos del INAH",
    "fa_ea_atscrp" => "Permisos del INBA",
    "fa_ea_salfor" => "Autorización de la SEP",
    "fa_ea_plca" => "Permisos del ISEM",
    "fa_ea_apfo" => "Permisos de CONAGUA",
);
foreach ($objFA as $key => $value) {
    foreach ($value as $key2 => $data) {
        reset($data);
        while (list($clave, $valor) = each($data)) {
            if ($valor == 1) {
                if ($key == "uso_suelo") {
                    $varFA1++;
                    $fA1 .= $arrayFA["$clave"] . ", ";
                }
                if ($key == "impacto_ambiental") {
                    $varFA2++;
                    $fA2 .= $arrayFA["$clave"] . ", ";
                }
                if ($key == "extensiones_avisos") {
                    $varFA3++;
                    $fA3 .= $arrayFA["$clave"] . ", ";
                }
            }
        }
    }
}
if ($varFA1 > 0) {
    $tabla .= "<tr nobr=\"true\">";
    if ($varFA2 > 0 && $varFA3 > 0) {
        $tabla .= "
                <td class=\"celdaTablaFicha encabezado\" rowspan=\"3\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
    } elseif ($varFA2 > 0 || $varFA3 > 0) {
        $tabla .= "
                <td class=\"celdaTablaFicha encabezado\" rowspan=\"2\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
    } else {
        $tabla .= "
                <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
    }
    $tabla .="
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">CAMBIO DE USO DE SUELO</td>
        <td class=\"celdaTablaFicha\" colspan=\"3\">";
    $fA1 = trim($fA1, ", ");
    $tabla .= $fA1 . "</td> </tr>";
}
if ($varFA2 > 0) {
    $tabla .= "<tr nobr=\"true\">";
    if ($varFA3 > 0 && !$varFA1) {
        $tabla .= "
                <td class=\"celdaTablaFicha encabezado\" rowspan=\"3\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
    } elseif (!$varFA3 && !$varFA1) {
        $tabla .= "
                <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
    }
    $tabla .="
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">MANIFESTACI&Oacute;N DE IMPACTO AMBIENTAL</td>
        <td class=\"celdaTablaFicha\" colspan=\"3\">";
    $fA2 = trim($fA2, ", ");
    $tabla .= $fA2 . "</td> </tr>";
}
if ($varFA3 > 0) {
    $tabla .= "<tr nobr=\"true\">";
    if (!$varFA1 && !$varFA2) {
        $tabla .= "
                <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
    }
    $tabla .="
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">MODIFICACIONES EXENCIONES Y AVISOS</td>
        <td class=\"celdaTablaFicha\" colspan=\"3\">";
    $fA3 = trim($fA3, ", ");
    $tabla .= $fA3 . "</td> </tr>";
}
//factibilidad Técnica
$varFT = 0;
$fT = "";
$jdFT = $estudio->hoja1->jfactibilidad_tecnica;
$objFT = json_decode($jdFT, true);
$arrayFT = array(
    "ft_cu_antpry" => "Anteproyecto",
    "ft_cu_pryeje" => "Proyecto Ejecutivo",
    "ft_cu_mecsue" => "Mecánica de Suelos",
    "ft_cu_esth" => "Estudio Hidrológico",
    "ft_cu_estt" => "Estudio Topográfico",
    "ft_cu_estit" => "Estudio de Ingeniería de Tránsito",
    "ft_cu_terref" => "Términos de Referencia",
);
foreach ($objFT as $key => $value) {
    foreach ($value as $key2 => $data) {
        reset($data);
        while (list($clave, $valor) = each($data)) {
            if ($valor == 1) {
                $varFT++;
                $fT .= $arrayFT["$clave"] . ", ";
            }
        }
    }
}
if ($varFT > 0) {
    $tabla .= "<tr nobr=\"true\">
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">FACTIBILIDAD T&Eacute;CNICA:</td>  
        <td class=\"celdaTablaFicha\" colspan=\"5\">";
    $fT = trim($fT, ", ");
    $tabla .= $fT . "</td>";
    $tabla .= "</tr>";
}
    echo $tabla;
    @endphp
</table>
