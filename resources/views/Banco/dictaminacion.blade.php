@extends('layouts.master')
@section('content')
<style type="text/css">
    .carrucel {
    width: 346px;
    background-color: #D3DFD1;
    height: 70px;
    margin-bottom: 5px;
}
</style>
<link href="/css/lightslider.css" rel="stylesheet"/>
<script src="/js/lightslider.js">
</script>
<div class="panel">
    <div class="row">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <p class="navbar-text">
                        No. Banco de Proyectos:
                    </p>
                    <form class="navbar-form navbar-left col-md-10" role="search">
                        <div class="form-group">
                            <input class="form-control text-right num" id="id_estudio_socioeconomico" name="id_estudio_socioeconomico" placeholder="Buscar" type="text" value="">
                            </input>
                        </div>
                        <span class="btn btn-default fa fa-search" id="buscar" title="Buscar Estudio">
                        </span>
                        <span class="btn btn-warning fa fa-refresh" id="limpiar" title="Limpiar pantalla">
                        </span>
                        <span class="btn btn-success fa fa-save" id="guardar" title="Guardar Evaluación">
                        </span>
                        <span class="btn btn-danger fa fa-share-square-o" id="enviar_observaciones" title="Enviar Observaciones a la Unidad Ejecutora">
                        </span>
                        <span class="btn btn-success fa fa-check-square-o" id="dictaminar" title="Dictaminar">
                        </span>
                        <span class="btn btn-success fa fa-file-pdf-o" id="evaluacion_pdf" title="Imprimir ficha técnica" >
                        </span>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</div>
<div class="container-fluid">
    <div class="panel panel-default">
        <form class="form-horizontal" id="evaluacion" role="form" style="background: none;">
            <fieldset id="f1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>
                            DATOS DE LA SOLICITUD:
                        </b>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <td class="text-right active" colspan="4">
                            </td>
                            <td class="col-sm-2 text-right active">
                                <b>
                                    Fecha de Ingreso:
                                </b>
                            </td>
                            <td class="col-sm-2">
                                <input class="form-control" id="fecha_ingreso" readonly="true" style="cursor: pointer; background-color: white;" type="text"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-right active">
                                <b>
                                    No. Banco:
                                </b>
                            </td>
                            <td class="col-sm-1 text-left" id="tIdBco">
                            </td>
                            <td class="col-sm-1 text-left" id="tIdSol" style="display:none;">
                            </td>
                            <td class="text-right active">
                                <b>
                                    Monto:
                                </b>
                            </td>
                            <td class="col-sm-1 text-right" id="tMonto">
                            </td>
                            <td class="col-sm-2 text-right active">
                                <b>
                                    Fecha de Captura:
                                </b>
                            </td>
                            <td class="col-sm-1 text-left" id="tFecCap">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-right active">
                                <b>
                                    Ejercicio:
                                </b>
                            </td>
                            <td class="col-sm-1 text-left" id="tEjercicio">
                            </td>
                            <td class="col-sm-2 text-right active">
                                <b>
                                    Duración Años:
                                </b>
                            </td>
                            <td class="col-sm-1 text-left" id="tDurAnio">
                            </td>
                            <td class="col-sm-2 text-right active">
                                <b>
                                    Duración Meses:
                                </b>
                            </td>
                            <td class="col-sm-1 text-left" colspan="3" id="tDurMes">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-right active">
                                <b>
                                    Solicitud:
                                </b>
                            </td>
                            <td class="col-sm-10 text-justify" colspan="7" id="tNomSol">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-right active">
                                <b>
                                    Sector:
                                </b>
                            </td>
                            <td class="col-sm-4 text-justify" colspan="2" id="tSector">
                            </td>
                            <td class="col-sm-2 text-right active">
                                <b>
                                    Unidad Ejecutora:
                                </b>
                            </td>
                            <td class="col-sm-4 text-justify" colspan="4" id="tUE">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-right active">
                                <b>
                                    Principales Caracteristicas:
                                </b>
                            </td>
                            <td class="col-sm-10 text-left" colspan="8" id="tPriCar">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-12 text-left active" colspan="10">
                                <b>
                                    Montos por fuente:
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-left active">
                                <b>
                                    Fuente Municipal:
                                </b>
                            </td>
                            <td class="col-sm-10 text-left" colspan="10" id="tFteMun">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-left active">
                                <b>
                                    Fuente Estatal:
                                </b>
                            </td>
                            <td class="col-sm-10 text-left" colspan="10" id="tFteEst">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-left active">
                                <b>
                                    Fuente Federal:
                                </b>
                            </td>
                            <td class="col-sm-10 text-left" colspan="10" id="tFteFed">
                            </td>
                        </tr>
                        <!--<tr>
                               <td class="col-sm-2 text-right active"><b>Fuente Municipal:</b></td>
                               <td id="tFteMun" class="col-sm-2 text-left"></td>
                               <td class="col-sm-2 text-right active"><b>Fuente Estatal:</b></td>
                               <td id="tFteEst" class="col-sm-2 text-left"></td>
                               <td class="col-sm-2 text-right active"><b>Fuente Federal:</b></td>
                               <td id="tFteFed" class="col-sm-2 text-left"></td>
                           </tr>-->
                    </table>
                </div>
                <br>
                    <div id="datosES" style="display:none;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label input-sm" for="CmbTipEva">
                                Tipo de Evaluación
                            </label>
                            <div class="col-sm-7">
                                <select class="form-control input-sm" id="CmbTipEva" name="CmbTipEva">
                                    <option value="">
                                        Seleccione una opción...
                                    </option>
                                    >
                                @foreach($tipoEvaluacion as $tipo)
                                    <option value="{{ $tipo->id }}">
                                        {{$tipo->nombre_evaluacion}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="TipInf">
                            <label class="col-sm-2 control-label input-sm" for="CmbTipInf">
                                Tipo de PPI
                            </label>
                            <div class="col-sm-3">
                                <select class="form-control input-sm" id="CmbTipInf" name="CmbTipInf">
                                    <option value="">
                                        Seleccione una opción...
                                    </option>
                                    >
                             @foreach($tipoPpi as $tipoP)
                                    <option value="{{ $tipoP->id }}">
                                        {{$tipoP->nombre_ppi}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label input-sm">
                            </label>
                            <div class="col-sm-7">
                                <span id="taObsDgiForCarr" name="taObsDgiForCarr">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label input-sm" for="taObsDgi">
                                Observaciones Generales
                            </label>
                            <div class="col-sm-7">
                                <textarea class="form-control input-sm" id="taObsDgi" maxlength="500" name="taObsDgi" rows="1">
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group" style="display: none">
                            <label class="col-sm-3 control-label input-sm" for="taObsDgi">
                                Accion a seguir
                            </label>
                            <div class="col-sm-7">
                                <select class="form-control input-sm" id="CmbTipFir" name="CmbTipFir">
                                    <option value="0">
                                    </option>
                                    <option selected="selected" value="1">
                                        Guardar cambios
                                    </option>
                                    <option value="2">
                                        Enviar observaciones a Unidad Ejecutora
                                    </option>
                                    <option value="3">
                                        Dictaminar
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="display: none">
                            <label class="col-sm-3 control-label input-sm text-right">
                                <input id="ingresoFisico" name="ingresoFisico" type="checkbox" value="1"/>
                            </label>
                            <div class="col-sm-7 text-left">
                                <label class="control-label input-sm text-left" for="ingresoFisico">
                                    Ingresar Estudio Socioeconómico Físico
                                </label>
                            </div>
                        </div>
                        <div class="panel panel-default" id="SubInc">
                            <div class="panel-heading">
                                <div class="row text-center">
                                    <b>
                                        <div class="col-sm-4">
                                            Concepto
                                        </div>
                                        <div class="col-sm-2 col-sm-offset-2 text-left">
                                            Página
                                        </div>
                                        <div class="col-sm-4 text-left">
                                            Observaciones
                                        </div>
                                    </b>
                                </div>
                            </div>
                            <table class="table">
                                <tbody id="TblSubInc">
                                    <tr>
                                        <td colspan="10">
                                            <center>
                                                No se ha seleccionado tipo de evaluación
                                            </center>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center" id="EtiInd">
                            <b>
                                INDICADORES DE RENTABILIDAD
                            </b>
                        </div>
                        <div class="form-group" id="TasDes">
                            <label class="col-sm-2 control-label input-sm" for="tfTasDes">
                                Tasa social de descuento
                            </label>
                            <div class="col-sm-1">
                                <input class="form-control input-sm" id="tfTasDes" name="tfTasDes" type="text" value="10"/>
                            </div>
                        </div>
                        <div id="InfEco">
                            <div class="form-group">
                                <label class="col-sm-2 control-label input-sm" for="tfVAN">
                                    VAN o VPN
                                </label>
                                <div class="col-sm-2">
                                    <input class="form-control input-sm" id="tfVAN" name="tfVAN" type="text"/>
                                </div>
                                <label class="col-sm-1 control-label input-sm" for="tfTIR">
                                    TIR
                                </label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm" id="tfTIR" name="tfTIR" type="text"/>
                                </div>
                                <label class="col-sm-1 control-label input-sm" for="tfTRI">
                                    TRI
                                </label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm" id="tfTRI" name="tfTRI" type="text"/>
                                </div>
                            </div>
                        </div>
                        <div id="InfSoc">
                            <div class="form-group">
                                <label class="col-sm-2 control-label input-sm">
                                    Proyecto Propuesto:
                                </label>
                                <label class="col-sm-2 control-label input-sm" for="tfVACPta">
                                    VAC o VPC
                                </label>
                                <div class="col-sm-2">
                                    <input class="form-control input-sm" id="tfVACPta" name="tfVACPta" type="text"/>
                                </div>
                                <label class="col-sm-2 control-label input-sm" for="tfCAEPta">
                                    CAE
                                </label>
                                <div class="col-sm-2">
                                    <input class="form-control input-sm" id="tfCAEPta" name="tfCAEPta" type="text"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label input-sm">
                                    Alternativa:
                                </label>
                                <label class="col-sm-2 control-label input-sm" for="tfVACAlt">
                                    VAC o VPC
                                </label>
                                <div class="col-sm-2">
                                    <input class="form-control input-sm" id="tfVACAlt" name="tfVACAlt" type="text"/>
                                </div>
                                <label class="col-sm-2 control-label input-sm" for="tfCAEAlt">
                                    CAE
                                </label>
                                <div class="col-sm-2">
                                    <input class="form-control input-sm" id="tfCAEAlt" name="tfCAEAlt" type="text"/>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <br/>
                    </div>
                </br>
            </fieldset>
        </form>
        <div id="formPdf" style="display: none">
        </div>
        <div id="valEva" style="display: none">
        </div>
    </div>
</div>
<script src="{{ asset('js/banco/main_banco.js') }}">
</script>
@endsection
