@extends('layouts.master')
@section('content')
<link href="/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<script src="/js/jquery.dataTables.min.js" type="text/javascript">
</script>
{{--
<script src="contenido_SGI/view/js/nl.js" type="text/javascript">
</script>
--}}
<style>
    .number{
        text-align: right;
    }
</style>
<div class="panel panel-default" id="panelGeneral">
    <div class="panel-heading">
        <h3 class="panel-title text-center">
            <strong>
                Autorización de Pago
            </strong>
        </h3>
    </div>
    <input type="hidden" name="id_oficio" id="id_oficio">
    <div class="panel-body" id="infoGralChild">
        <div class="form-horizontal">
            <div class="form-group">
                <div class="col-md-3 col-md-offset-1">
                    <div class="input-group">
                        <span class="input-group-addon input-sm">Acción a seguir:</span>
                        <select class="form-control input-sm" aria-describedby="basic-addon1" id="accion" name="accion">
                            <option value="0">- Selecciona</option>
                            <option value="1">Creación</option>
                            <option value="2">Modificación</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 col-md-offset-1" id="div_id_obra" style="display:none;">
                    <div class="input-group">
                        <span class="input-group-addon input-sm">No. de Obra:</span>
                        <input type="text" class="form-control input-sm numero" aria-describedby="basic-addon1" id="id_obra" name="id_obra" placeholder="0" />
                    </div>
                </div>
                <div class="col-md-3 col-md-offset-1" id="div_folio_ap" style="display:none;">
                    <div class="input-group">
                        <span class="input-group-addon input-sm">Folio A.P.:</span>
                        <input type="text" class="form-control input-sm numero" aria-describedby="basic-addon1" id="clave" name="clave" placeholder="0" />
                    </div>
                </div>
                <div class="col-md-2" id="div_ejercicio" style="display:none;">
                    <div class="input-group">
                        <span class="input-group-addon input-sm">Ejercicio:</span>
                        <select name="ejercicio_obra" id="ejercicio_obra" class="form-control input-sm">
                            @foreach ($ejercicios as $ejercicio)
                                <option value="{{$ejercicio->ejercicio}}">{{$ejercicio->ejercicio}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="div_buscar" style="display:none;">
                    <button class="btn btn-default btn-sm" id="btnBuscar">Buscar&nbsp;
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        
            <div id="divGeneral" style="display:;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Datos Generales
                        </div>
                        <div class="panel-body">
                            <div class="row form-group">
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <div class="input-group-addon btn-sm">Folio de Autorización de Pago:</div>
                                        <input type="text" class="form-control input-sm" id="folio_ap" readonly="true" />
                                        <input type="hidden" class="form-control input-sm" id="id_ap" readonly="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">                               
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <div class="input-group-addon btn-sm">Estimaci&oacute;n:</div>
                                        <input type="text" class="form-control input-sm" id="numero_estimacion"/>
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon btn-sm">Ejecutora:</div>
                                        <input type="text" class="form-control input-sm" id="ejecutoraAp" readonly="true"/>
                                        <input type="hidden" class="form-control input-sm" id="id_unidad_ejecutora" readonly="true"/>
                                        <input type="hidden" class="form-control input-sm" id="id_sector" readonly="true"/>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- <div class="row form-group">
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <div class="input-group-addon btn-sm">RFC:</div>
                                        <input type="text" class="form-control input-sm" id="rfc"/><input type="text" id="id_empresa" style="display:none;" />
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-addon btn-sm">Beneficiario:</div>
                                        <input type="text" class="form-control input-sm" id="nombre_beneficiario" readonly="true"/>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row form-group">
                                <div class="col-md-6">
                                    <div id="popRFC" title="RFC no existe">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                RFC de empresa:
                                            </span>
                                            <input id="bnueva_empresa" name="bnueva_empresa" type="hidden"/>
                                            <input id="id_empresa" name="id_empresa" type="hidden"/>
                                            <input class="form-control obligatorioHoja4" id="rfc" name="rfc" placeholder="" type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Padrón del contratista:
                                        </span>
                                        <input class="form-control " id="padron_contratista" name="padron_contratista" placeholder="" type="text" readonly="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Empresa:
                                        </span>
                                        <input class="form-control obligatorioHoja4" id="nombre" name="nombre" placeholder="" type="text" readonly="true"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                           Nombre del respresentante:
                                        </span>
                                        <input class="form-control " id="nombre_representante" name="nombre_representante" placeholder="" type="text" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Cargo:
                                            </span>
                                            <input class="form-control obligatorioHoja4" id="cargo_representante" name="cargo_representante" placeholder="" type="text" readonly="true"/>
                                        </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <div class="input-group-addon btn-sm">Modalidad de Ejecución:</div>
                                         <input type="text" class="form-control input-sm" id="modalidadEjecucion" readonly="true" />
                                    </div>
                                </div>
                                 <div class="col-sm-3">
                                    <div class="input-group">
                                        <div class="input-group-addon btn-sm">Avance F&Iacute;sico:</div>
                                         <input type="text" class="form-control input-sm" id="avFis" value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-addon btn-sm">Observaciones:</div>
                                        <textarea class="form-control input-sm" id="observaciones"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group" id="divTipo" style="display: ;">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="input-group">
                                <span class="input-group-addon input-sm"><strong>Movimiento:</strong></span>
                                <select name="id_tipo" id="id_tipo" class="form-control input-sm">
                                        <option value="-1">Seleccione...</option>
                                    @foreach ($tipoMovimiento as $tipo)
                                        <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group" id="divFuentes" style="display:none;">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="input-group">
                                <span class="input-group-addon input-sm"><strong>Fuente:</strong></span>
                                <select name="id_fuente" id="id_fuente" class="form-control input-sm">
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group" id="divContratos" style="display:none;">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="input-group">
                                <span class="input-group-addon input-sm"><strong>Contrato:</strong></span>
                                <select name="id_contrato" id="id_contrato" class="form-control input-sm">
                                    {{-- {!! $opciones['ejercicio'] !!} --}}
                                </select>
                                <input type="hidden" id="derechoAnticipo" value="0">
                                <input type="hidden" id="porcentajeAnticipo" value="0" >
                            </div>
                        </div>
                    </div>
                    

                {{-- INICIA LAYOUT ANTICIPO --}}
                    <div id="layoutAnticipo" style="display:none;">
                        <div class="row form-group" id="divContratoAnticipo" style="display:none;">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon input-sm"><strong>Contrato:</strong></span>
                                    <select name="id_contrato_anticipo" id="id_contrato_anticipo" class="form-control input-sm">
                                        {{-- {!! $opciones['ejercicio'] !!} --}}
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="divAnticipoAdm" style="display:none;">
                            <div class="row form-group  form-group-sm" >
                                <label for="montoObraAdm" class="col-sm-2 col-md-offset-1 control-label">Monto autorizado:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="montoObraAdm" class="form-control input-sm number" readonly="true" value="0.00"/>
                                </div>
                           
                           
                                <label for="montoDisponibleObraAdm" class="col-sm-2 control-label">Monto disponible:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="montoDisponibleObraAdm" class="form-control input-sm number" readonly="true" value="0.00"/>
                                </div>
                            </div>
                            <div class="row form-group form-group-sm">
                                <label for="montoAnticipoAdm" class="col-sm-1 col-md-offset-6 control-label">Anticipo:</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control input-sm number" id="montoAnticipoAdm" value="0.00"/>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group" id="divTablaFuentesAnticipo" style="display: none;">
                            <div class="col-sm-9 col-md-offset-1">
                                <table id="tablaFuentesAnticipo" class="table table-bordered" style="width:100%">
                                    <thead>
                                    <th>idFte</th>
                                    <th>Fuente de financiamiento</th>
                                    <th>Cuenta</th>
                                    <th>Monto de anticipo</th>
                                    <th>Folio A.P.</th>
                                    <th></th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div> 
                 {{-- END LAYOUT ANTICIPO --}}

                 {{-- INICIA LAYOUT AMORTIZACION --}}
                    <div id="layoutAmortizacion" style="display:none;">
                        <div class="row form-group form-group-sm">
                            <div class="col-sm-5">
                                <label for="foliosAmortizar" class="col-sm-5 control-label">Folio a amortizar:</label>
                                <div class="col-sm-7">
                                    <select id="foliosAmortizar" name="foliosAmortizar"  class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <label for="montoPorAmortizar" class="col-sm-5 control-label">Monto por amortizar:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control input-sm number" id="montoPorAmortizar" value="0.00" readonly="true"/>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <div class="col-sm-5 col-md-offset-5">
                                <label for="montoPorAmortizar" class="col-sm-5 control-label">Monto:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control input-sm number" id="montoParaAmortizar"  value="0.00"/>
                                </div>
                            </div>
                        </div>
                    </div> 
                 {{-- END LAYOUT AMORTIZACION --}}

                 {{-- INICIA LAYOUT ESTIMACION --}}
                    <div id="layoutEstimacion" style="display:none;">
                        <div class="row form-group form-group-sm">
                            <div class="col-sm-3 col-md-offset-1">
                                    <label for="foliosAmortizar" class="col-sm-5 control-label">Monto:</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control input-sm number" id="montoEstimacion" value="0.00" />
                                    </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="montoPorAmortizar" class="col-sm-5 control-label">Amortización:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control input-sm number" id="montoAmortizacion" value="0.00" readonly="true"/>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="montoPorAmortizar" class="col-sm-6 control-label">I.V.A. Amortización:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control input-sm number" id="ivaAmortizacion" value="0.00" readonly="true"/>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-group-sm">
                             <div class="col-sm-12">
                                    <label for="folioAmortiza" class="col-sm-2 col-md-offset-7 control-label">Folio que Amortiza:</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control input-sm number" id="folioAmortiza" readonly="true"/>
                                    </div>
                            </div>
                        </div>
                    </div> 
                 {{-- END LAYOUT ESTIMACION --}}      


                 {{-- INICIA LAYOUT DE AFECTACIÓN PRESUPUESTAL--}}
                    <div id="divAfectacion" style="display: none;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Aplicaci&oacute;n Presupuestal
                            </div>
                            <div class="panel-body">
                                <div class="form-horizontal">
                                    <div class="form-group form-group-sm">
                                        <div class="col-sm-2 col-md-offset-1">
                                            <label for="sinivaAp" class="control-label">Importe sin IVA:</label><input type="text" id="sinivaAp" class="form-control input-sm number" readonly="true" value="0.00" />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="amortizacionAp" class="control-label">Amortizaci&oacute;n:</label><input type="text" id="amortizacionAp" class="form-control input-sm number" readonly="true" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="icicAp" class="control-label">I.C.I.C (0.2%):</label><input type="text"  id="icicAp" class="form-control input-sm number" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="isptAp" class="control-label">ISPT:</label><input type="text" id="isptAp" class="form-control input-sm number" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="isptAp" class="control-label">Federal (0.2%):</label><input type="text" id="federal02Ap" class="form-control input-sm number" value="0.00"/>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm">
                                        <div class="col-sm-2 col-md-offset-1">
                                            <label for="subtotalAp" class="control-label">Subtotal:</label><input type="text" id="subtotalAp" class="form-control input-sm number" readonly="true" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="ivaAp" class="control-label">IVA:</label><input type="text" id="ivaAp" class="form-control input-sm number" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="cmicAp" class="control-label">C.M.I.C (0.5%):</label><input type="text" id="cmicAp" class="form-control input-sm number" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="otroAp" class="control-label">Otro:</label><input type="text" id="otroAp" class="form-control input-sm number" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="isptAp" class="control-label">Federal (0.5%):</label><input type="text" id="federal05Ap" class="form-control input-sm number" value="0.00"/>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm">
                                        <div class="col-sm-2 col-md-offset-1">
                                            <label for="afectacionAp" class="control-label">Afect. Presupuestal:</label><input type="text" id="afectacionAp" class="form-control input-sm number" readonly="true" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="netoAp" class="control-label">Importe Neto:</label><input type="text" id="netoAp" class="form-control input-sm number" readonly="true" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="supervisionAp" class="control-label">Supervisi&oacute;n (2%):</label><input type="text" id="supervisionAp" class="form-control input-sm number" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="isptAp" class="control-label">Federal (0.1%):</label><input type="text" id="federal01Ap" class="form-control input-sm number" value="0.00"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="totalAp" class="control-label">Total Retenciones:</label><input type="text" id="totalAp" class="form-control input-sm number" readonly="true" value="0.00"/>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm">
                                        <div class="col-sm-10 col-md-offset-1">
                                            <label for="afectacionAp" class="control-label">Importe Neto con letra:</label>
                                            <input type="text" id="letranetoAp" class="form-control input-sm number" readonly="true"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 {{-- END LAYOUT AFECTACIÓN PRESUPUESTAL--}}

                </div>
            </div>
        </div>
    </div>
</div>
<div id="contenidoFormPdf" style="display: none">
    <form action="contenido_SGI/view/Oficios/pdfOficio.php" id="viewPdf" method="post" name="viewPdf" target="_blank">
        <input id="idOficioPdf" name="idOficioPdf" type="hidden" value=""/>
    </form>
    <form action="contenido_SGI/libs/phpWord/write/oficio.php" id="viewWord" method="post" name="viewWord" target="_blank">
        <input id="idOficioWord" name="idOficioWord" type="hidden" value=""/>
    </form>
</div>
<style type="text/css">
    .input-group{
        z-index: 0 !important;
    }
</style>
<script src="{{ asset('js/AutorizacionPago/crear_autorizacion_pago.js') }}">
</script>
@endsection
