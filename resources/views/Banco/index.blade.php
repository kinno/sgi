@extends('layouts.master')
@section('content')
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <p class="navbar-text">No. Banco de Proyectos:</p>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control text-right num" placeholder="Buscar" id="numerobanco" name="numerobanco" value="">
                </div>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalMostrarD" id="mostraredit">
                    Mostrar Datos
                </button>
                <button type="button" id="btnRefresh" class="btn btn-primary" >
                    Limpiar
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="panel panel-default">
        <form id="evaluacion" class="form-horizontal" role="form" style="background: none;">
            <fieldset id="f1">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>DATOS DE LA SOLICITUD:</b></div>
                    <table class="table table-bordered">
                        <tr>
                            <td class="text-right active" colspan="4"></td>
                            <td class="col-sm-2 text-right active"><b>Fecha&nbsp;de&nbsp;Ingreso:</b></td>
                            <td class="col-sm-2"><input type="text" id="tFecIng" class="form-control" style="cursor: pointer; background-color: white;" readonly="true"/></td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-right active"><b>No. Banco:</b></td>
                            <td id="tIdBco" class="col-sm-1 text-left"></td>

                            <!--                            <td class="col-sm-1 text-right active"><b>No. de Solicitud:</b></td>-->
                            <td id="tIdSol" class="col-sm-1 text-left" style="display:none;"></td>

                            <td class="text-right active"><b>Monto:</b></td>
                            <td id="tMonto" class="col-sm-1 text-right">&nbsp;</td>
                            <td class="col-sm-2 text-right active"><b>Fecha&nbsp;de&nbsp;Captura:</b></td>
                            <td id="tFecCap" class="col-sm-1 text-left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-right active"><b>Ejercicio:</b></td>
                            <td id="tEjercicio" class="col-sm-1 text-left"></td>
                            <td class="col-sm-2 text-right active"><b>Duraci&oacute;n A&ntilde;os:</b></td>
                            <td id="tDurAnio" class="col-sm-1 text-left"></td>
                            <td class="col-sm-2 text-right active"><b>Duraci&oacute;n Meses:</b></td>
                            <td colspan="3" id="tDurMes" class="col-sm-1 text-left"></td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-right active"><b>Solicitud:</b></td>
                            <td colspan="7" id="tNomSol" class="col-sm-10 text-justify"></td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-right active"><b>Sector:</b></td>
                            <td colspan="2" id="tSector" class="col-sm-4 text-justify"></td>
                            <td class="col-sm-2 text-right active"><b>Unidad Ejecutora:</b></td>
                            <td colspan="4" id="tUE" class="col-sm-4 text-justify"></td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-right active"><b>Principales Caracteristicas:</b></td>
                            <td colspan="8" id="tPriCar" class="col-sm-10 text-left"></td>
                        </tr>
                        <tr><td colspan="10" class="col-sm-12 text-left active"><b>Montos por fuente:</b></td></tr>
                        <tr>
                            <td class="col-sm-2 text-left active"><b>Fuente Municipal:</b></td>
                            <td colspan="10" id="tFteMun" class="col-sm-10 text-left"></td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-left active"><b>Fuente Estatal:</b></td>
                            <td colspan="10" id="tFteEst" class="col-sm-10 text-left"></td>
                        </tr>
                        <tr>
                            <td class="col-sm-2 text-left active"><b>Fuente Federal:</b></td>
                            <td colspan="10" id="tFteFed" class="col-sm-10 text-left"></td>
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
                   <div id="datosES" style="">
                    <div class="form-group">
                        <label for="CmbTipEva" class="col-sm-2 control-label input-sm">Tipo de Evaluaci&oacute;n</label>
                        <div class="col-sm-7">
                            <select name="CmbTipEva" id="CmbTipEva" class="form-control input-sm">
                                <option value="">Seleccione una opción...</option>>
                                @foreach($tipoEvaluacion as $tipo)
                                <option value="{{ $tipo->id }}">{{$tipo->nombre_evaluacion}}</option>   
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="TipInf">
                        <label for="CmbTipInf" class="col-sm-2 control-label input-sm">Tipo de PPI</label>
                        <div class="col-sm-3">
                            <select name="CmbTipInf" id="CmbTipInf" class="form-control input-sm">
                             <option value="">Seleccione una opción...</option>>
                             @foreach($tipoPpi as $tipoP)
                             <option value="{{ $tipoP->id }}">{{$tipoP->nombre_ppi}}</option>   
                             @endforeach
                         </select>
                     </div>
                 </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label input-sm"></label>
                    <div class="col-sm-7">
                        <span name="taObsDgiForCarr" id="taObsDgiForCarr" ></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="taObsDgi" class="col-sm-2 control-label input-sm">Observaciones Generales</label>
                    <div class="col-sm-7">
                        <textarea name="taObsDgi" id="taObsDgi" class="form-control input-sm" rows="1" maxlength="500"></textarea>
                    </div>
                </div>
                <div class="form-group" style="display: none">
                    <label for="taObsDgi" class="col-sm-3 control-label input-sm">Accion a seguir</label>
                    <div class="col-sm-7">
                        <select name="CmbTipFir" id="CmbTipFir" class="form-control input-sm">
                            <option value="0"></option>
                            <option value="1" selected="selected">Guardar cambios</option>
                            <option value="2">Enviar observaciones a Unidad Ejecutora</option>
                            <option value="3">Dictaminar</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display: none">
                    <label class="col-sm-3 control-label input-sm text-right">
                        <input type="checkbox" name="ingresoFisico" id="ingresoFisico" value="1" />
                    </label>
                    <div class="col-sm-7 text-left">
                        <label for="ingresoFisico" class="control-label input-sm text-left">Ingresar Estudio Socioecon&oacute;mico F&iacute;sico</label>
                    </div>
                </div>
                <div class="panel panel-default" id="SubInc">
                    <div class="panel-heading">
                        <div class="row text-center">
                            <b>
                                <div class="col-sm-4">Concepto</div>
                                <div class="col-sm-2 col-sm-offset-2 text-left">P&aacute;gina</div>
                                <div class="col-sm-4 text-left">Observaciones</div>
                            </b>
                        </div>
                    </div>
                    <table class="table">
                        <tbody id="TblSubInc"><tr><td colspan="10"><center>No se ha seleccionado tipo de evaluaci&oacute;n</center></td></tr></tbody>
                    </table>
                </div>

                <div class="text-center" id="EtiInd"><b>INDICADORES DE RENTABILIDAD</b></div>
                <div class="form-group" id="TasDes">
                    <label for="tfTasDes" class="col-sm-2 control-label input-sm">Tasa social de descuento</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control input-sm" name="tfTasDes" id="tfTasDes" value="10" />
                    </div>
                </div>
                <div id="InfEco">
                    <div class="form-group">
                        <label for="tfVAN" class="col-sm-2 control-label input-sm">VAN o VPN</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control input-sm" name="tfVAN" id="tfVAN" />
                        </div>
                        <label for="tfTIR" class="col-sm-1 control-label input-sm">TIR</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control input-sm" name="tfTIR" id="tfTIR" />
                        </div>
                        <label for="tfTRI" class="col-sm-1 control-label input-sm">TRI</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control input-sm" name="tfTRI" id="tfTRI" />
                        </div>
                    </div>
                </div>
                <div id="InfSoc">
                    <div class="form-group">
                        <label class="col-sm-2 control-label input-sm">Proyecto Propuesto:</label>
                        <label for="tfVACPta" class="col-sm-2 control-label input-sm">VAC o VPC</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control input-sm" name="tfVACPta" id="tfVACPta" />
                        </div>
                        <label for="tfCAEPta" class="col-sm-2 control-label input-sm">CAE</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control input-sm" name="tfCAEPta" id="tfCAEPta" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label input-sm">Alternativa:</label>
                        <label for="tfVACAlt" class="col-sm-2 control-label input-sm">VAC o VPC</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control input-sm" name="tfVACAlt" id="tfVACAlt" />
                        </div>
                        <label for="tfCAEAlt" class="col-sm-2 control-label input-sm">CAE</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control input-sm" name="tfCAEAlt" id="tfCAEAlt" />
                        </div>
                    </div>
                </div>
                <br />
                <br />
                <div class="form-group panel-heading" >
                    <div class="col-sm-5 text-right">
                        <span id="btnEnviarObs" class="btn btn-success">Enviar Observaciones</span>
                    </div>
                    <div class="col-sm-1 text-right">
                        <span id="btnDictaminar" class="btn btn-success">Dictaminar</span>
                    </div>
                    <div class="col-sm-2 text-right">
                        <span id="btnGuardarEvaluacion" class="btn btn-success">Guardar</span>
                    </div>

                    <div class="col-sm-1 text-left">
                        <span id="btnEvaluacionPdf" class="btn btn-success" style="display: none">PDF</span>
                    </div>
                    <div class="col-sm-1 text-left">&nbsp;</div>
                </div>
            </div>

        </fieldset>
    </form>
    <div id="formPdf" style="display: none"></div>
    <div id="valEva" style="display: none"></div>

</div>
</div>
<script src="{{ asset('js/banco/main.js') }}"></script>
@endsection