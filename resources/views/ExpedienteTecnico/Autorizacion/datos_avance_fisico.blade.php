<div class="row">
    <div class="col-md-12 panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <b>
                    Programa de Avance Físico (%)
                </b>
            </div>
            <div class="panel-body">
                <p>
                    Para el programa en general
                </p>
                <table class="table table-bordered table-hover" id="tablaPrograma" style="font-size: 12px; width: 100%;">
                    <thead>
                        <tr style="font-size: 12px;">
                            <th style="display: none;">
                            </th>
                            <th style=" text-align:center; vertical-align: middle;">
                                Concepto de Trabajo
                            </th>
                            <th>
                                ENE
                            </th>
                            <th>
                                FEB
                            </th>
                            <th>
                                MAR
                            </th>
                            <th>
                                ABRL
                            </th>
                            <th>
                                MAY
                            </th>
                            <th>
                                JUN
                            </th>
                            <th>
                                JUL
                            </th>
                            <th>
                                AGO
                            </th>
                            <th>
                                SEP
                            </th>
                            <th>
                                OCT
                            </th>
                            <th>
                                NOV
                            </th>
                            <th>
                                DIC
                            </th>
                            <th>
                                TOTAL
                            </th>
                            <th>
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <span class="btn btn-default" id="btnAddModal">
                    Agregar
                </span>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="modal1" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                    <span class="sr-only">
                        Close
                    </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Principales Conceptos de Trabajo
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar los principales conceptos o acciones en el desarrollo de la obra o acción.">
                    </span>
                </h4>
            </div>
            <div class="modal-body">
                <!--                <form class="form-horizontal" method="POST" id="formdemodal1">-->
                <div class="row">
                    <div class="form-group form-group-sm">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-4">
                                Concepto de Trabajo:
                            </div>
                            <div class="col-xs-16 col-md-8">
                                <input class="form-control input-sm " id="contrato" name="contrato" placeholder="Ingresa" type="text" value=""/>
                                <input id="isEdit" name="isEdit" type="hidden" value="0"/>
                                <input id="indexTable" name="indexTable" type="hidden" value="0"/>
                                <input id="valIndex0" name="valIndex0" type="hidden" value="0"/>
                                <input id="isAdmin" name="isAdmin" type="hidden" value="0"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-1">
                                ENE:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="ene" maxlength="40" name="ene" placeholder="" type="text"/>
                            </div>
                            <div class="col-xs-2 col-md-1">
                                FEB:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="feb" maxlength="40" name="feb" placeholder="" type="text"/>
                            </div>
                            <div class="col-xs-2 col-md-1">
                                MAR:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="mar" maxlength="40" name="mar" placeholder="" type="text" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-1">
                                ABR:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="abr" maxlength="40" name="abr" placeholder="" type="text" value=""/>
                            </div>
                            <div class="col-xs-2 col-md-1">
                                MAY:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="may" maxlength="40" name="may" placeholder="" type="text" value=""/>
                            </div>
                            <div class="col-xs-2 col-md-1">
                                JUN:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="jun" maxlength="40" name="jun" placeholder="" type="text" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-1">
                                JUL:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="jul" maxlength="40" name="jul" placeholder="" type="text" value=""/>
                            </div>
                            <div class="col-xs-2 col-md-1">
                                AGO:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="ago" maxlength="40" name="ago" placeholder="" type="text" value=""/>
                            </div>
                            <div class="col-xs-2 col-md-1">
                                SEP:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="sep" maxlength="40" name="sep" placeholder="" type="text" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-1">
                                OCT:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="oct" maxlength="40" name="oct" placeholder="" type="text" value=""/>
                            </div>
                            <div class="col-xs-2 col-md-1">
                                NOV:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="nov" maxlength="40" name="nov" placeholder="" type="text" value=""/>
                            </div>
                            <div class="col-xs-2 col-md-1">
                                DIC:
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <input class="form-control input-sm numerote mesFinanciero" id="dic" maxlength="40" name="dic" placeholder="" type="text" value=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group form-group-sm">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-2">
                                <label class="col-lg-3 control-label">
                                    TOTAL:
                                </label>
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <label class="col-lg-3 control-label" id="totaldecontra">
                                    0%
                                </label>
                            </div>
                            <div class="col-xs-4 col-md-7">
                                <span class="btn btn-primary " id="agregamodal1" name="agregamodal1">
                                    Agregar
                                </span>
                                <span class="btn btn-primary " data-dismiss="modal" id="cancelarmodal1" name="cancelarmodal1">
                                    Cancelar
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                </form>-->
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/Expediente_Tecnico/Autorizacion/detalle_avance_fisico.js') }}">
</script>