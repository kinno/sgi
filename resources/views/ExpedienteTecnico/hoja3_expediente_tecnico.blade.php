<div class="panel panel-default" id="clictotal">
    <div class="panel-heading">
        <h1 class="panel-title">
            <strong>
                ANEXO 3
            </strong>
        </h1>
    </div>
    <div class="panel-body">
        <div class="form-group form-group-sm">
            <p class="panel-title">
                <strong>
                    <h5>
                        PRESUPUESTO DE LA OBRA O ACCIÓN
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Objetivo: Identificar los conceptos 
                              de gasto y su reporte.">
                        </span>
                    </h5>
                </strong>
            </p>
        </div>
        
        <div class="form-group form-group-sm">
            <div class="col-md-2 col-md-offset-5">
                <span class="btn btn-default" id="abreModal">
                    Agregar
                </span>
            </div>
        </div>
        
        <div class="form-group form-group-sm">
            <div class="container-fluid " id="divConceptos">
                <table class="table table-bordered" id="tablaConceptos" style="font-size: 12px; width: 100%;">
                    <thead>
                        <tr>
                            <th>
                                id
                            </th>
                            <th style=" text-align:center;">
                                Clave por objeto de gasto
                            </th>
                            <th>
                                Concepto
                            </th>
                            <th>
                                Unidad de Medida
                            </th>
                            <th>
                                Cantidad
                            </th>
                            <th>
                                Precio Unitario
                            </th>
                            <th>
                                Importe sin I.V.A
                            </th>
                            <th>
                                IVA
                            </th>
                            <th>
                                Total
                            </th>
                            <th>
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td style="text-align: right;">
                                Total:
                            </td>
                            <td class="numberTemp">
                                <span class="number" id="totalSinIva">
                                    0.00
                                </span>
                            </td>
                            <td class="numberTemp">
                                <span class="number" id="totalIva">
                                    0.00
                                </span>
                            </td>
                            <td class="numberTemp">
                                <span class="number" id="total">
                                    0.00
                                </span>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div id="cargaExterna">
        <div class="container-fluid">
            <div class="col-md-1">
                <a class="btn btn-default glyphicon glyphicon-save" href="descargar_plantilla" id="descargarTemplate" target="_blank" title="Descargar plantilla de conceptos">
                </a>
            </div>
            <div class="col-md-6">
                <form id="formCargaExterna" role="form" enctype='multipart/form-data'>
                    <input id="archivoExcel" name="archivoExcel" type="file">
                    </input>
                </form>        
            </div>
            <div class="col-md-1">
                <span id="subirCatalogo" title="Cargar archivo" class="btn btn-default fa fa-upload" style="display: none;"></span>
            </div>
        </div>
    </div>
    <div class="panel-body alert-warning col-md-9 col-xs-offset-1" id="error25Ampliacion" style="display:none;">
        <div>
            <p class="panel-title">
                <strong>
                    Atención:
                </strong>
                Se superó el 25% del monto autorizado, se debe ingresar nuevo Estudio Socioeconómico
            </p>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="modalConcepto" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" data-dismiss="modal">
                    <span aria-hidden="true">
                        ×
                    </span>
                    <span class="sr-only">
                        Close
                    </span>
                </span>
                <h4 class="modal-title" id="myModalLabel">
                    Catálogo de Conceptos
                </h4>
            </div>
            <div class="modal-body">
                <div class="row form-group form-group-sm">
                    <div class="col-lg-11">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon1">
                                Clave por objeto de gasto:
                            </span>
                            <input aria-describedby="sizing-addon1" class="form-control input-sm input-sm" id="clave" maxlength="40" name="clave" type="text" value="">
                            </input>
                        </div>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar los 4 dígitos de acuerdo al clasificador por 
                          objeto de gasto.">
                    </span>
                </div>
                <div class="row form-group form-group-sm">
                    <div class="col-lg-11">
                        <div class="input-group ">
                            <span class="input-group-addon" id="sizing-addon2">
                                Concepto:
                            </span>
                            <textarea aria-describedby="sizing-addon2" class="form-control input-sm" id="concepto" name="concepto" rows="2"></textarea>
                        </div>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar en forma detallada los trabajos a realizar para llevar 
                          a cabo la obra o acción.">
                    </span>
                </div>
                <div class="row form-group form-group-sm">
                    <div class="col-lg-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon3">
                                Unidad de Medida:
                            </span>
                            <input aria-describedby="sizing-addon3" class="form-control input-sm" id="unidadm" maxlength="40" name="unidadm" placeholder="" type="text">
                            </input>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar la categoría que clasifica el objeto de gasto. (Pieza, metro,
                              kilómetro, litro, etc.)">
                        </span>
                    </div>
                    <div class="col-lg-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon4">
                                Cantidad:
                            </span>
                            <input aria-describedby="sizing-addon4" class="form-control input-sm number" id="cantidad" maxlength="40" name="cantidad" placeholder="" type="text" value="">
                            </input>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el número de unidades de la categoría.">
                        </span>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row form-group form-group-sm">
                    <div class="col-lg-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon5">
                                Precio Unitario:
                            </span>
                            <input aria-describedby="sizing-addon3" class="form-control input-sm number" id="preciou" maxlength="40" name="preciou" placeholder="" type="text" value="">
                            </input>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el precio por Unidad de Medida, sin IVA.">
                        </span>
                    </div>
                    <div class="col-lg-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon6">
                                Importe sin I.V.A.:
                            </span>
                            <input aria-describedby="sizing-addon4" class="form-control input-sm number" id="impsiniva" name="impsiniva" readonly="true" type="text" value="0.00">
                            </input>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Resultado de la multiplicación de la cantidad por el precio unitario, sin IVA.">
                        </span>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row form-group form-group-sm">
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input aria-label="check" id="ivaCheck" type="checkbox">
                                    <input class="number" id="iva" name="iva" type="hidden">
                                    </input>
                                </input>
                            </span>
                            <input aria-label="ivaCheck" class="form-control input-sm col-lg-1" placeholder="I.V.A." readonly="" type="text">
                            </input>
                        </div>
                        <!-- /input-group -->
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Cálculo del impuesto al valor agregado de 
                          acuerdo a las disposiciones fiscales.">
                    </span>
                </div>
              
                <div class="modal-footer">
                    <div class="form-group form-group-sm">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-2">
                                <label class="col-lg-3 control-label">
                                    TOTAL:
                                </label>
                            </div>
                            <div class="col-xs-1 col-md-1">
                                <span class="glyphicon glyphicon-question-sign ayuda" title="Suma del impuesto al 
                                      valor agregado y el importe sin IVA.">
                                </span>
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <label class="col-lg-3 control-label number" id="totalConcepto">
                                    0.00
                                </label>
                            </div>
                            <div class="col-xs-4 col-md-6">
                                <span class="btn btn-success " id="agregaConcepto" name="agregaConcepto">
                                    Agregar
                                </span>
                                <span class="btn btn-success" id="actualizarConcepto" name="actualizarConcepto" style="display:none;">
                                    Actualizar
                                </span>
                                <input id="idContrato" type="hidden"/>
                                <input id="idFte" type="hidden"/>
                                <span class="btn btn-warning " id="cancelarConcepto" name="cancelarConcepto">
                                    Cancelar
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-20 col-md-12">
                            <div class="col-xs-2 col-md-2">
                                <span class="glyphicon glyphicon-pencil" name="m" title="Ajustar decimales" onclick="ajustardec();" style="cursor:pointer;alignment-adjust: after-edge;">
                                </span>
                            </div>
                            <div class="col-xs-2 col-md-6">
                                <div class="row form-group form-group-sm" hidden="true" id="contEd">
                                    <div class="col-md-10">
                                        <input id="decScroll" type="text">
                                        </input>
                                    </div>
                                    <div class="col-md-1">
                                        <span class="btn fa fa-reply" title="Aceptar" style="cursor: pointer" onclick="ajustaDec();">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
