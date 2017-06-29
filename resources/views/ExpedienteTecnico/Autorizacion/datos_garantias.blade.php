<style type="text/css">
    .input-group .form-control {
    z-index: 0 !important;
}
</style>
<form class="form-horizontal" id="form_garantias" role="form">
<div class="row form-group" id="rowGarantia" >
    <div class="col-md-12 panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                Garantía de anticipo
            </div>
            <div class="panel-body">
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">
                                Folio:
                            </span>
                            <input class="form-control" id="folio_garantia" name="folio_garantia" type="text"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">
                                Fecha de emisión:
                            </span>
                            <input class="form-control fecha" id="fecha_emision_garantia" name="fecha_emision_garantia" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">
                                Importe con IVA:
                            </span>
                            <input class="form-control number" id="importe_garantia" name="importe_garantia" type="text" value="0.00" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Del:
                            </span>
                            <input class="form-control fecha" id="fecha_inicio_garantia" name="fecha_inicio_garantia" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Al:
                            </span>
                            <input class="form-control fecha" id="fecha_fin_garantia" name="fecha_fin_garantia" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                Anticipo
            </div>
            <div class="panel-body">
                <div class="row form-group">
                    <input id="bndAnticipo" name="bndAnticipo" type="hidden" value="0"/>
                    <input id="isAutorizedAnticipo" name="isAutorizedAnticipo" type="hidden" value="0"/>
                    <div class="col-md-6" id="anticipo_group">
                            <div class="input-group" >
                                <span class="input-group-addon" id="basic-addon1">
                                    Importe:
                                </span>
                                <input class="form-control number" id="importe_anticipo" name="importe_anticipo" type="text" value="0.00"/>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">
                                %
                            </span>
                            <input class="form-control porcentaje" id="porcentaje_anticipo" name="porcentaje_anticipo" type="text"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Forma de pago:
                            </span>
                            <input class="form-control" id="forma_pago_anticipo" name="forma_pago_anticipo" type="text"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                Garantía de cumplimiento
            </div>
            <div class="panel-body">
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">
                                Folio:
                            </span>
                            <input class="form-control obligatorioHoja4" id="folio_garantia_cumplimiento" name="folio_garantia_cumplimiento" type="text"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">
                                Fecha de emisión:
                            </span>
                            <input class="form-control fecha obligatorioHoja4" id="fecha_emision_garantia_cumplimiento" name="fecha_emision_garantia_cumplimiento" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">
                                Importe con IVA:
                            </span>
                            <input class="form-control number obligatorioHoja4" id="importe_garantia_cumplimiento" name="importe_garantia_cumplimiento" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Del:
                            </span>
                            <input class="form-control fecha obligatorioHoja4" id="fecha_inicio_garantia_cumplimiento" name="fecha_inicio_garantia_cumplimiento" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Al:
                            </span>
                            <input class="form-control fecha obligatorioHoja4" id="fecha_fin_garantia_cumplimiento" name="fecha_fin_garantia_cumplimiento" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script src="{{ asset('js/Expediente_Tecnico/Autorizacion/detalle_garantias.js') }}">
</script>