@extends('layouts.master')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title text-center">
            <strong>
                Detalle del Contrato
            </strong>
        </h3>
    </div>
    <div class="panel-body">
        <input id="idcontrato" name="idcontrato" type="hidden"/>
        <input id="idcontratoPadre" name="idcontratoPadre" type="hidden"/>
        <input id="indexTableContrato" name="indexTableContrato" type="hidden"/>
        <input id="isEditContrato" name="isEditContrato" type="hidden"/>
        <input id="isConvenio" name="isConvenio" type="hidden"/>
        <div class="row form-group">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">
                        Número:
                    </span>
                    <input aria-describedby="basic-addon1" class="form-control obligatorioHoja4" id="noContrato" name="noContrato" placeholder="" type="text"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">
                        F. de celebración:
                    </span>
                    <input class="form-control fechaHoja4 obligatorioHoja4" id="fecCelebracion" name="fecCelebracion" placeholder="" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <h4>
                    <span class="label label-default">
                        Objeto del contrato:
                    </span>
                </h4>
            </div>
            <div class="col-md-9">
                <textarea class="form-control obligatorioHoja4" id="descContrato" name="descContrato" placeholder="">
                </textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <div id="popRFC" title="RFC no existe">
                    <div class="input-group">
                        <span class="input-group-addon">
                            RFC de empresa:
                        </span>
                        <input id="idRFC" name="idRFC" type="hidden"/>
                        <input class="form-control obligatorioHoja4" id="empresaRFC" name="empresaRFC" placeholder="" type="text"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        Padrón del contratista:
                    </span>
                    <input class="form-control " id="numPadronContratista" name="numPadronContratista" placeholder="" type="text"/>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon">
                        Empresa:
                    </span>
                    <input class="form-control obligatorioHoja4" id="empresaContrato" name="empresaContrato" placeholder="" type="text"/>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon">
                        Unidad Ejecutora u organismo:
                    </span>
                    <span class="form-control" id="orgOfObr" readonly="true">
                    </span>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        Tipo de contrato:
                    </span>
                    <select class="form-control obligatorioHoja4" id="tipoContrato">
                        <option value="">
                            Seleccione
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        Oficio de asignación:
                    </span>
                    <span class="form-control" id="numOfiAsiContrato" readonly="true">
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        Fecha de oficio de asignación:
                    </span>
                    <span class="form-control" id="fecOfiAsiContrato" readonly="true">
                    </span>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" id="tblFuenteContrato">
                    <thead>
                        <tr class="success">
                            <th>
                                Fuente de financiamiento
                            </th>
                            <th>
                                %
                            </th>
                            <th>
                                Monto total
                            </th>
                            <th>
                                Monto disponible
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        Modalidad de Adjudicación:
                    </span>
                    <select class="form-control obligatorioHoja4" id="modAdjContrato">
                        <option value="">
                            Seleccione
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">
                        Número de obra:
                    </span>
                    <span class="form-control" id="numObrContrato" readonly="true">
                    </span>
                </div>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-addon">
                        Nombre de obra:
                    </span>
                    <span class="form-control" id="nomObrContrato" readonly="true" style="overflow-y: auto;">
                    </span>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        Cobertura:
                    </span>
                    <span class="form-control" id="coberturaContrato" readonly="true">
                        cobertura de la obra
                    </span>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <h4>
                    <span class="label label-default">
                        Despcripción de la obra:
                    </span>
                </h4>
            </div>
            <div class="col-md-9">
                <span id="descObrContrato">
                </span>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        Monto del contrato (incluye IVA):
                    </span>
                    <input class="form-control numero2" id="montoContrato" name="montoContrato" readonly="true" type="text"/>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Plazo de ejecución
                    </div>
                    <div class="panel-body">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">
                                        Fecha de inicio:
                                    </span>
                                    <input class="form-control fechaHoja4 obligatorioHoja4" id="fecInicioContr" name="fecInicioContr" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">
                                        Fecha de término:
                                    </span>
                                    <input class="form-control fechaHoja4 obligatorioHoja4" id="fecTerminoContr" name="fecTerminoContr" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        Días calendario:
                                    </span>
                                    <input class="form-control" id="diasContrato" name="diasContrato" readonly="true" type="text"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        Disponibilidad del inmueble:
                    </span>
                    <select class="form-control obligatorioHoja4" id="dispInmuContrato">
                        <option value="">
                            Seleccione
                        </option>
                        <option value="1">
                            Sí
                        </option>
                        <option value="0">
                            No
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row form-group" id="rowMotivos" style="display: none;">
            <div class="col-md-7">
                <div class="col-md-3">
                    <h4>
                        <span class="label label-default">
                            Motivos:
                        </span>
                    </h4>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control obligatorioHoja4" id="motivosNoDispContrato" name="motivosNoDispContrato">
                    </textarea>
                </div>
            </div>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-addon">
                        Fecha de disponibilidad:
                    </span>
                    <input class="form-control fechaHoja4 obligatorioHoja4" id="fecDisponibilidadInm" name="fecDisponibilidadInm" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        Tipo de obra (contrato):
                    </span>
                    <select class="form-control obligatorioHoja4" id="tipObrContr">
                        <option value="">
                            Seleccione
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
