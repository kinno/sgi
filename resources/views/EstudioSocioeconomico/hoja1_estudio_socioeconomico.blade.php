
<form class="form-horizontal" role="form" id="form_anexo_uno">
{{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title"><strong> HOJA 1</strong></h1>
            <input id="id_hoja_uno" name="id_hoja_uno" type="hidden">
        </div>
        <div class="panel-body">
            <div class="row form-group" id="nes">
                <label class="col-md-3 col-md-offset-1 control-label" for="nbp">No. Banco de Proyectos:</label>
                <div class="col-md-2">
                    <input id="estudio_socioeconomico" name="estudio_socioeconomico" type="text" class="form-control input-md" readonly="readonly">
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Folio del Banco de Proyectos."></span>
            </div>


            <div class="row form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="ejercicio"><font color="red" size="2">*</font>Ejercicio:</label>
                <div class="col-md-2">
                    <select id="ejercicio" name="ejercicio" class="form-control obligatorio">
                        @foreach($ejercicios as $ejercicio)
                        <option value="{{$ejercicio->Ejercicio}}">{{$ejercicio->Ejercicio}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="vida_proyecto">Vida &uacute;til del proyecto:</label>
                <label class="col-md-1 control-label">A&ntilde;os</label>
                <div class="col-md-1">
                    <input id="vida_proyecto" name="vida_proyecto" type="text" onkeypress="return justNumbers(event);" class="form-control input-sm" maxlength="2">
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="nombre_obra"><font color="red" size="2">* </font>Nombre de la obra:</label>
                <div class="col-md-7">
                    <textarea class="form-control obligatorio" id="nombre_obra" name="nombre_obra" rows="2"></textarea>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar la denominaci&oacute;n de la obra oacci&oacute;n, de tal manera que permita identificar con claridad los trabajos a realizar y suubicaci&oacute;n."></span>
            </div>


            <div id="depnoruni">
                <div class="row form-group">
                    <label class="col-md-3 col-md-offset-1 control-label" for="ue">Unidad Ejecutora:</label>
                    <div class="col-md-7" id="ue0">
                    <input type="text" name="unidad_ejecutora" id="unidad_ejecutora" val="unidad_ejecutora" class="form-control">
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Unidad Administrativa de acuerdo al
                      Cat&aacute;logo de Centros de Costo, a nivel jer&aacute;rquico de una Direcci&oacute;n General
                      o de un Organismo Auxiliar (Organismo Descentralizado, Empresa de Participaci&oacute;n Estatal
                      y Fideicomiso P&uacute;blico) que estar&aacute; a cargo directo del desarrollo del plan,
                      programa o acci&oacute;n.">
                </span>
                </div>

                <div class="row form-group">
                    <label class="col-md-3 col-md-offset-1 control-label" for="ur">Sector:</label>
                    <div class="col-lg-7" id="ur0">
                    <input type="text" name="sector" id="sector" val="sector" class="form-control">
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Secretar&iacute;a de acuerdo a su
                      denominaci&oacute;n en la Ley Org&aacute;nica de la Administraci&oacute;n P&uacute;blica, de la
                      Consejer&iacute;a Jur&iacute;dica, Procuradur&iacute;a General de Justicia o del &Oacute;rgano
                      Aut&oacute;nomo, a la cual este adscrita la Unidad Ejecutora y quien tendr&aacute; la
                      responsabilidad de coordinar y evaluar su desempe&ntilde;o en el ejercicio del presupuesto asignado.">
                </span>
                </div>
            </div>

            <div id="usuariouni" hidden="true">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="ue2">Unidad Ejecutora:</label>
                    <div class="col-md-8">
                        <select id="ue2" name="ue2" class="form-control">
                        </select>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Unidad Administrativa de acuerdo al
                      Cat&aacute;logo de Centros de Costo, a nivel jer&aacute;rquico de una Direcci&oacute;n General
                      o de un Organismo Auxiliar (Organismo Descentralizado, Empresa de Participaci&oacute;n Estatal
                      y Fideicomiso P&uacute;blico) que estar&aacute; a cargo directo del desarrollo del plan,
                      programa o acci&oacute;n.">
                </span>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="ur2">Sector:</label>
                    <div class="col-md-4">
                        <select id="ur2" name="ur2" class="form-control">
                        </select>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Secretar&iacute;a de acuerdo a su
                      denominaci&oacute;n en la Ley Org&aacute;nica de la Administraci&oacute;n P&uacute;blica, de la
                      Consejer&iacute;a Jur&iacute;dica, Procuradur&iacute;a General de Justicia o del &Oacute;rgano
                      Aut&oacute;nomo, a la cual este adscrita la Unidad Ejecutora y quien tendr&aacute; la
                      responsabilidad de coordinar y evaluar su desempe&ntilde;o en el ejercicio del presupuesto asignado.">
                </span>
                </div>
            </div>

            <div id="usuedit" hidden="true">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="ue3">Unidad Ejecutora:</label>
                    <div class="col-md-6">
                        <input id="ue3" name="ue3" type="text" placeholder="" class="form-control input-md" readonly>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Unidad Administrativa de acuerdo al
                      Cat&aacute;logo de Centros de Costo, a nivel jer&aacute;rquico de una Direcci&oacute;n General
                      o de un Organismo Auxiliar (Organismo Descentralizado, Empresa de Participaci&oacute;n Estatal
                      y Fideicomiso P&uacute;blico) que estar&aacute; a cargo directo del desarrollo del plan,
                      programa o acci&oacute;n.">
                </span>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="ur3">Sector:</label>
                    <div class="col-md-6">
                        <input id="ur3" name="ur3" type="text" placeholder="" class="form-control input-md" readonly>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Secretar&iacute;a de acuerdo a su
                      denominaci&oacute;n en la Ley Org&aacute;nica de la Administraci&oacute;n P&uacute;blica, de la
                      Consejer&iacute;a Jur&iacute;dica, Procuradur&iacute;a General de Justicia o del &Oacute;rgano
                      Aut&oacute;nomo, a la cual este adscrita la Unidad Ejecutora y quien tendr&aacute; la
                      responsabilidad de coordinar y evaluar su desempe&ntilde;o en el ejercicio del presupuesto asignado.">
                </span>
                </div>
            </div>

            <div id="accfed">
                <div class="row form-group">
                    <label class="col-lg-3 col-md-offset-4 control-label">Acciones de Gobierno Federal</label>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la(s) opci&oacute;n(es) de tres
                    letras, tres n&uacute;meros y texto completo que identifican la(s) Acci&oacute;n(es) de Gobierno.">
                </span>
                </div>

                <div id="mult">
                    <div class="panel-body">
                        <div class="col-sm-12" id="aF">
                            <select name="accion_federal[]" id="accion_federal" class="form-control input-md" multiple="multiple">
                                @foreach($accionesFederales as $accionFederal)
                                    <option value="{{$accionFederal->id}}">{{$accionFederal->clave_acuerdo}} {{$accionFederal->nombre_acuerdo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <label class="col-lg-3 col-md-offset-4 control-label">Acciones de Gobierno Estatal</label>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la(s) opci&oacute;n(es) de tres
                letras, tres n&uacute;meros y texto completo que identifican la(s) Acci&oacute;n(es) de Gobierno.">
            </span>
            </div>

            <div id="mult">
                <div class="panel-body">
                    <div class="col-sm-12" id="aE">
                        <select name="accion_estatal[]" id="accion_estatal" class="form-control input-md" multiple="multiple">
                            @foreach($accionesEstatales as $accionEstatal)
                                <option value="{{$accionEstatal->id}}">{{$accionEstatal->clave_acuerdo}} {{$accionEstatal->nombre_acuerdo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <label for="justificacion_obra" class="col-md-3 col-md-offset-1 control-label"><font color="red" size="2">* </font>Justificaci&oacute;n de la obra:</label>
                <div class="col-md-7"><textarea class="form-control obligatorio" name="justificacion_obra" rows="2" id="justificacion_obra"></textarea></div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="modalidad"><font color="red" size="2">* </font>Modalidad de ejecuci&oacute;n:</label>
                <div class="col-md-2">
                    <select id="id_modalidad_ejecucion" name="id_modalidad_ejecucion" class="form-control obligatorio">
                        <option value="">Seleccione...</option>
                        <option value="1">Contrato</option>
                        <option value="2">Administración</option>
                    </select>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la opci&oacute;n 'Contrato' en el
                caso de que la ejecuci&oacute;n de una obra o la prestaci&oacute;n de un servicio se encomienden a
                una empresa; de igual manera la modalidad ser&aacute; por contrato, cuando se trate de la
                adquisici&oacute;n de un bien o servicio. Seleccionar la opci&oacute;n 'Administraci&oacute;n' cuando la obra
                o acci&oacute;n se realice por la Unidad Ejecutora, siempre y cuando cuente con los recursos humanos,
                materiales y t&eacute;cnicos conforme a los lineamientos establecidos en el Libro D&e&eacute;cimo
                Segundo del C&oacute;digo Administrativo y en su Reglamento. En este sentido deber&aacute; anexarse al
                Expediente, la informaci&oacute;n que sustente esta condici&oacute;n.">
          </span>
            </div>

            <div class="row form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="id_tipo_obra"><font color="red" size="2">* </font>Tipo de obra:</label>
                <div class="col-md-2">
                    <select id="id_tipo_obra" name="id_tipo_obra" class="form-control obligatorio">
                        <option value="">Seleccione...</option>
                        <option value="1">Nueva</option>
                        <option value="2">En proceso</option>
                    </select>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar 'Nueva' si la obra se ejecutar&aacute;
                con presupuesto del presente ejercicio fiscal y el cuadro 'Proceso' si el presupuesto para la
                ejecuci&oacute;n de la obra se asign&oacute; el a&ntilde;o o a&ntilde;os anteriores, o si se trata de
                una ampliaci&oacute;n o reducci&oacute;n de presupuesto.">
                </span>
            </div>

            <div id="todo">
                <div class="form-group">
                    <label for="monto" class="col-lg-3 control-label"><font color="red" size="2">* </font>Monto de la Inversi&oacuten: </label>
                    <div class="col-lg-3" id="tres">
                        <input type="text" class="form-control text-right obligatorio" id="monto" name="monto" readonly/>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la Fuente de financiamiento para
                        llevar a cabo la obra o acci&oacute;n. En caso de ser m&aacute;s de una fuente, deber&aacute;
                        colocar el importe que corresponda a cada una de ellas.">
                    </span>
                </div>

                <div class="form-group ftefederal">
                    <label class="col-lg-3 control-label" id="labelfed">Federal: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control monfed text-right" name="monto_fuente_federal[]" value="" />
                    </div>

                    <!--<div id="catffed">-->
                    <label class="col-lg-1 control-label">Fuente:</label>
                    <div class="col-lg-4">
                        <select name="fuente_federal[]" class="form-control numftef" >
                         <option value="">Seleccione...</option>
                        @foreach($fuentesFederal as $fuenteF)
                        <option value="{{$fuenteF->id}}">{{$fuenteF->descripcion}}</option>
                        @endforeach
                        </select>
                    </div>
                <!--</div>-->

                    <input class="bt_ftefed input-sm" type="button" value="+"/>
                </div>

                <div class="form-group fteestatal">
                    <label class="col-lg-3 control-label" id="labeles">Recursos Fiscales (Estatal): </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control monest text-right" name="monto_fuente_estatal[]" value="" />
                    </div>

            {{--<!--<div id="catfest">-->--}}
                    <label class="col-lg-1 control-label">Fuente:</label>
                    <div class="col-lg-4">
                        <select name="fuente_estatal[]" class="form-control numftee" >
                        <option value="">Seleccione...</option>
                        @foreach($fuentesEstatal as $fuenteE)
                        <option value="{{$fuenteE->id}}">{{$fuenteE->descripcion}}</option>
                        @endforeach
                        </select>
                    </div>
                    <!--</div>-->
                    <input class="bt_fteest input-sm" type="button" value="+" />
                </div>

                    <div class="form-group">
                        <label for="ejemplo_password_3" class="col-lg-3 control-label" id="labelmu">Municipal: </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control monmun text-right" id="monto_fuente_municipal" name="monto_fuente_municipal" value=""/>
                        </div>

                        <div id="catfmun">
                            <label class="col-lg-1 control-label">Fuente:</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control numftem" id="fuente_municipal" name="fuente_municipal" maxlength="30">
                            </div>
                        </div>

                    </div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 control-label" for="principales_caracteristicas"><font color="red" size="2">* </font>Principales caracter&iacute;sticas:</label>
                <div class="col-md-7">
                    <textarea class="form-control obligatorio" id="principales_caracteristicas" name="principales_caracteristicas" rows="2"></textarea>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Describir las principales caracter&iacute;sticas
                    de la obra o acci&oacute;n.">
                </span>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Grupo Social:</label>
                <div class="col-lg-4">
                    <select id="id_grupo_social" class="form-control" name="id_grupo_social">
                        <option value="">Seleccione...</option>
                        @foreach($grupoSocial as $grupo)
                        <option value="{{$grupo->IdGpo}}">{{$grupo->NomGpo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-5 control-label">Metas a lograr</label>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la unidad de medida que
                    corresponda a la meta que se alcanzar&aacute; al concluirse la obra o acci&oacute;n.">
                </span>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label"><font color="red" size="2">* </font>U. Medida:</label>
                <div class="col-lg-3">

                    <select class="form-control obligatorio" id="id_meta" name="id_meta">
                    <option value="">Seleccione...</option>
                    @foreach($metas as $meta)
                    <option value="{{$meta->id}}">{{$meta->nombre}}</option>
                    @endforeach
                    </select>

                </div>

                <div class="col-lg-1">
                    <label class="col-lg-2 control-label">Cantidad:</label>
                </div>
                <div class="col-lg-2">
                    <input type="text" class="form-control text-right number-oneDec" name="cantidad_meta" id="cantidad_meta" placeholder="0">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-5 control-label">Beneficiarios</label>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el n&uacute;mero de personas
                    beneficiadas con la ejecuci&oacute;n de la obra o acci&oacute;n. Asimismo se anotar&aacute; la
                    unidad de medida que corresponda de acuerdo al cat&aacute;logo correspondien.">
                </span>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">U. Medida:</label>
                <div class="col-lg-3">
                    <select class="form-control"  id="id_beneficiario" name="id_beneficiario">
                    <option value="">Seleccione...</option>
                    @foreach($beneficiarios as $beneficiario)
                    <option value="{{$beneficiario->id}}">{{$beneficiario->nombre}}</option>
                    @endforeach
                    </select>
                </div>

                <div class="col-lg-1">
                    <label class="col-lg-2 control-label">Cantidad:</label>
                </div>

                <div class="col-lg-2">
                    <input type="text" name="cantidad_beneficiario" class="form-control number-int text-right" id="cantidad_beneficiario" placeholder="0">

                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Duraci&oacute;n de la Obra:</label>
                <label class="col-lg-1 control-label"><font color="red" size="2">* </font>A&ntilde;os:</label>
                <div class="col-lg-1"><input type="text" id="duracion_anios" name="duracion_anios" class="form-control tiempo text-right" onkeypress="return justNumbers(event);" placeholder="0" maxlength="2"></div>
                <label class="col-lg-1 control-label"><font color="red" size="2">* </font>Meses:</label>
                <div class="col-md-1">
                    <select id="duracion_meses" name="duracion_meses" class="form-control">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-5 control-label">Factibilidades</label>
            </div>

            @include('EstudioSocioeconomico.factibilidades')

        </div>
    </div>


    <!--
    <div class="form-group" id="nes">
      <label class="col-md-3 control-label" for="firmar">
        <input id='firmar' name='firmar' type="checkbox" value="1">
        Enviar estudio socioecon&oacute;mico para dictaminar
      </label>
    </div>
    -->
</form>


<div class="form-group col-md-10">
    <label class="col-lg-6 control-label"></label>
    <h6><font color="red" size="2">* </font>Campos obligatorios.</h6>
</div>



<input hidden="true" id="usuuni" name="usuuni">
<input hidden="true" id="sig2" name="guar">
<input hidden="true" id="rut" name="rut">
<input hidden="true" id="valsig" name="valsig">
<input hidden="true" id="accionGuardar" name='accion' value="guardadoHoja1EstSoc">
<input type="hidden" id="isFM" name="isFM"/>
<input type="hidden" id="idDetFon" name="idDetFon"/>

<div class="modal fade" id="modalFM">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><b>Selecci&oacute;n de proyecto del Fondo Metropolitano</b></h5>
            </div>
            <div class="modal-body">
                <p>Seleccione el proyecto correspondiente al <span id="tipoFM"></span></p>
                <table class="table table-bordered" id="tablaProyectosFM">
                    <thead>
                    <tr>
                        <th>idFte</th>
                        <th>idDetFon</th>
                        <th>Clave del proyecto</th>
                        <th>Nombre del proyecto</th>
                        <th>Monto disponible</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <input type="hidden" id="indexTableFM"/>
            </div>
            <div class="modal-footer">
                <span type="button" class="btn btn-default" data-dismiss="modal">Cancelar</span>
                <span type="button" class="btn btn-primary" id="btnAceptarFM">Aceptar</span>
            </div>
        </div>
    </div>
</div>

