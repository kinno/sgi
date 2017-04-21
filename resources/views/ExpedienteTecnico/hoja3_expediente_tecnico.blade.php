<div class="panel panel-default" id="clictotal">
    <div class="panel-heading">
        <h1 class="panel-title"><strong> ANEXO 3</strong></h1>
    </div>
    <div class="panel-body">
        <div>
            <p class="panel-title"><strong><h5>PRESUPUESTO DE LA OBRA O ACCI&Oacute;N  
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Objetivo: Identificar los conceptos 
                              de gasto y su reporte.">
                        </span>         
                    </h5></strong></p>
        </div>	
    </div>
    <div class="panel panel-default">

        <div class="form-group">
            <div><p class="panel-title">&nbsp;</p></div>
            <div class="row col-xs-16 col-md-12">
                <div class="col-xs-2 col-md-1">

                </div>
                <div class="col-xs-2 col-md-4">
<!--                    <div class="col-md-6">
                        <div class="input-group" id="pp">
                            <span class="input-group-addon">
                                <input type="checkbox" id="pariPassu" checked="checked">
                            </span>
                            <input type="text" readonly class="form-control col-lg-1" aria-label="pariPassu" placeholder="Pari passu ">
                        </div> /input-group 
                    </div>-->
                    <div class="col-md-6">
                        <div class="input-group" id="pp">
                            <span class="btn btn-default" onclick="prorrateo()">Distribuir fuentes</span>
                        </div><!-- /input-group -->
                    </div>

                </div>
                <div class="col-xs-2 col-md-2">
                    <span class="btn btn-default" id="abreModal">Agregar</span></a>
                </div>
                <div class="col-xs-2 col-md-5"></div>
            </div>
        </div> 

        <div class="container-fluid " id="divConceptos">
            <table class='table table-bordered' id="tablaConceptos" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th >id</th>
                        <th style=" text-align:center;">Clave por objeto de gasto</th>
                        <th>Concepto</th>
                        <th>Unidad de Medida</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Importe sin I.V.A</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Fuente</th>
                        <th>Relacion</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td ></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">Total:</td>
                        <td class="numberTemp"><span id="totalSinIva" class="number">0.00</span></td>
                        <td class="numberTemp"><span id="totalIva" class="number">0.00</span></td>
                        <td class="numberTemp"><span id="total" class="number">0.00</span></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>  
                </tfoot>
            </table>
        </div>

    </div>
    <div id="cargaExterna" >
        <div class="container-fluid">  
            <div class="col-md-1">
                <a href="contenido_SGI/uploads/plantillaConceptos.xls" target="_blank" id="descargarTemplate" class="btn btn-default glyphicon glyphicon-save" title="Descargar plantilla de conceptos"></a>
            </div>
            <div class="col-md-6">
                <span id="cargaCatalogoConceptos">Cargar Conceptos</span>
            </div>
        </div>
    </div>
    <div id="errorRelPreFte" class="panel-body alert-danger col-md-6 col-xs-offset-3" style="display:none;">
        <div>
            <p class="panel-title"><strong>Atenci&oacute;n: </strong>Se deben relacionar los conceptos con las fuentes</p>
        </div>	
    </div>
    <div id="error25Ampliacion" class="panel-body alert-warning col-md-9 col-xs-offset-1" style="display:none;">
        <div>
            <p class="panel-title"><strong>Atenci&oacute;n: </strong>Se super&oacute; el 25% del monto autorizado, se debe ingresar nuevo Estudio Socioecon&oacute;mico</p>
        </div>	
    </div>
</div>

<div id="modalConcepto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></span>
                <h4 class="modal-title" id="myModalLabel">Cat&aacute;logo de Conceptos</h4>
            </div>        
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-lg-11">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon1">Clave por objeto de gasto:</span>
                            <input type="text" class="form-control" aria-describedby="sizing-addon1" id="clave" name="clave" value="" maxlength="40">
                        </div>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar los 4 d&iacute;gitos de acuerdo al clasificador por 
                          objeto de gasto.">
                    </span>
                </div>

                <div class="row form-group">
                    <div class="col-lg-11">
                        <div class="input-group ">
                            <span class="input-group-addon" id="sizing-addon2">Concepto:</span>
                            <textarea class="form-control" id="concepto" name="concepto" rows="2" aria-describedby="sizing-addon2"></textarea>
                        </div>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar en forma detallada los trabajos a realizar para llevar 
                          a cabo la obra o acci&oacute;n.">
                    </span>
                </div>    

                <div class="row form-group">
                    <div class="col-lg-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon3">Unidad de Medida:</span>
                            <input type="text" class="form-control" placeholder="" id="unidadm" name="unidadm"  maxlength="40" aria-describedby="sizing-addon3">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar la categor&iacute;a que clasifica el objeto de gasto. (Pieza, metro,
                              kil&oacute;metro, litro, etc.)">
                        </span>
                    </div>
                    <div class="col-lg-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon4">Cantidad:</span>
                            <input type="text" class="form-control number" placeholder="" id="cantidad" name="cantidad" value="" maxlength="40" aria-describedby="sizing-addon4">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el n&uacute;mero de unidades de la categor&iacute;a.">
                        </span>
                    </div>
                </div><!-- /.row -->

                <div class="row form-group">
                    <div class="col-lg-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon5">Precio Unitario:</span>
                            <input type="text" class="form-control number" placeholder="" id="preciou" name="preciou" value="" maxlength="40" aria-describedby="sizing-addon3">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el precio por Unidad de Medida, sin IVA.">
                        </span>
                    </div>
                    <div class="col-lg-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon6">Importe sin I.V.A.:</span>
                            <input type="text" class="form-control number" id="impsiniva" name="impsiniva" value="0.00" readonly="true" aria-describedby="sizing-addon4">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Resultado de la multiplicaci&oacute;n de la cantidad por el precio unitario, sin IVA.">
                        </span>
                    </div>
                </div><!-- /.row -->

                <div class="row form-group">
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" aria-label="check" id="ivaCheck">
                                <input type="hidden" class="number" id="iva" name="iva">
                            </span>
                            <input type="text" readonly class="form-control col-lg-1" aria-label="ivaCheck" placeholder="I.V.A.">
                        </div><!-- /input-group -->
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="C&aacute;lculo del impuesto al valor agregado de 
                          acuerdo a las disposiciones fiscales.">
                    </span>
                    </div>
                <div id="divFtes">
<!--                    <div class="col-lg-9">
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon7">Fuente:</span>
                                <select id="ftes" class="form-control" aria-describedby="sizing-addon7"></select>
                            </div>            
                    </div>-->
                </div>

                <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-2"><label class="col-lg-3 control-label">TOTAL:</label></div>
                            <div class="col-xs-1 col-md-1">
                                <span class="glyphicon glyphicon-question-sign ayuda" title="Suma del impuesto al 
                                      valor agregado y el importe sin IVA.">
                                </span>
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <label class="col-lg-3 control-label number" id="totalConcepto">0.00</label>
                            </div>
                            
                            <div class="col-xs-4 col-md-6">
                                <span   id="agregaConcepto" name="agregaConcepto" class="btn btn-primary ">Agregar</span>
                                <span   id="actualizarConcepto" name="actualizarConcepto" class="btn btn-primary" style="display:none;">Actualizar</span>
                                <input type="hidden" id="idContrato"/>
                                <input type="hidden" id="idFte"/>
                                <span   id="cancelarConcepto" name="cancelarConcepto" class="btn btn-primary ">Cancelar</span>
                            </div>
                        </div> 
                        <div class="col-xs-20 col-md-12">
                            <div class="col-xs-2 col-md-2">
                                <span class="glyphicon glyphicon-pencil" style="cursor:hand; alignment-adjust: after-edge;" onClick="ajustardec();" name="m"></span>
                            </div>
                            <div class="col-xs-2 col-md-6">
                                <div class="row form-group" id="contEd" hidden="true">
                                    <div class="col-md-10">
                                        <input type="text" id="decScroll">
                                    </div>
                                    <div class="col-md-2">
                                        <span class="btn btn-primary glyphicon glyphicon-ok btn-xs" onClick="ajustaDec();"></span>
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