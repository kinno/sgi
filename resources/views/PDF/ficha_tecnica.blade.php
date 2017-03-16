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
<pre>{{dd($estudio)}}</pre>
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
            {{$estudio->hoja1->id_sector}}
        </td>
    </tr>
    <tr>
        <td class="celdaTablaFicha encabezado">
            UNIDAD EJECUTORA:
        </td>
        <td class="celdaTablaFicha" colspan="6">
            {{$estudio->hoja1->id_unidad_ejecutora}}
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
            {{$estudio->hoja2->id_cobertura}}
        </td>
        @if ($estudio->hoja2->id_cobertura==2)
        <td class="celdaTablaFicha encabezado">
            REGIONES:
        </td>
        <td class='\"celdaTablaFicha\"' colspan='\"4\"'>
        @elseif ()
        @else
        @endif

      {{--   {{ if ($infoBcoPDF['IdCob'] === "2") {
                $inicio_tabla_nomProyecto .= "
                   
                        ";
                $regionesFicha = "";
                for ($i = 0; $i < count($infoBcoPDF['regiones']); $i++) {
                    $regionesFicha .= $infoBcoPDF['regiones'][$i]['CveReg'] . " " . utf8_encode($infoBcoPDF['regiones'][$i]['NomReg']) . ", ";
                }
                $regionesFicha = trim($regionesFicha, ", ");
                $inicio_tabla_nomProyecto .= $regionesFicha . "
        </td>
        ";
            } else if ($infoBcoPDF['IdCob'] === "3") {
                $inicio_tabla_nomProyecto .= "
        <td class='\"celdaTablaFicha' encabezado\"="">
            MUNICIPIOS:
        </td>
        <td class='\"celdaTablaFicha\"' colspan='\"4\"'>
            ";
                $municipiosFicha = "";
                for ($i = 0; $i < count($infoBcoPDF['municipios']); $i++) {
                    $municipiosFicha .= utf8_encode($infoBcoPDF['municipios'][$i]['NomMun']) . ", ";
                }
                $municipiosFicha = trim($municipiosFicha, ", ");
                $inicio_tabla_nomProyecto .= $municipiosFicha . "
        </td>
        ";
                    }
         }} --}}
    </tr>
</table>