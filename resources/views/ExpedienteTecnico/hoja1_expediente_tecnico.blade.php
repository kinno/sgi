<form class="form-horizontal" id="form_anexo_uno" role="form">
    {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">
                <strong>
                    ANEXO 1
                </strong>
            </h1>
            <input id="id_hoja_uno" name="id_hoja_uno" type="hidden" value="">
            </input>
        </div>
        <div class="panel-body">
            <div class="form-group" id="sp">
                <label class="col-md-3 col-md-offset-1 control-label" for="id_tipo_solicitud">
                    <font color="red" size="2">
                        *
                    </font>
                    Solicitud de presupuesto:
                </label>
                <div class="col-md-4">
                    <select class="form-control obligatorioHoja1" id="id_tipo_solicitud" name="id_tipo_solicitud">
                        <option value="">
                            Seleccione...
                        </option>
                        @foreach ($tipoSolicitud as $value)
                        <option value="{{$value->id}}">
                            {{$value->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar según corresponda el tipo de trámite.">
                </span>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="bevaluacion_socioeconomica">
                    <font color="red" size="2">
                        *
                    </font>
                    Se Incluye Evaluación Socioeconómica:
                </label>
                <div class="col-md-2">
                    <select class="form-control am-as obligatorioHoja1" id="bevaluacion_socioeconomica" name="bevaluacion_socioeconomica">
                        <option value="">
                            Seleccionar...
                        </option>
                        <option value="1">
                            Si
                        </option>
                        <option value="2">
                            No
                        </option>
                        <option value="3">
                            En proceso
                        </option>
                    </select>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Indicar si cuenta con Estudio 
                      Socioeconómico, en caso de ser afirmativo colocar el folio del Banco de Proyectos.">
                </span>
            </div>
            <div class="form-group" hidden="true" id="nes">
                <label class="col-md-3 col-md-offset-1 control-label" for="nbp">
                    No. Banco de Proyectos:
                </label>
                <div class="col-md-2">
                    <input class="form-control input-md am-as" id="id_estudio_socioeconomico" name="id_estudio_socioeconomico" type="text"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="idsol">
                    No. Solicitud:
                </label>
                <div class="col-md-2">
                    <input class="form-control input-md" id="id_expediente_tecnico" name="id_expediente_tecnico" placeholder="" readonly="" type="text"/>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="De uso exclusivo de la Dirección 
                      General de Inversión, para anotar el número progresivo correspondiente al ingreso 
                      del expediente Técnico.">
                </span>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="noobra">
                    No. de Obra:
                </label>
                <div class="col-md-2">
                    <input class="form-control input-md am-as" id="id_obra" name="id_obra" readonly="" type="text"/>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Número de Control que identifica a la obra
                      o acción y que se incluye en el documento Anexo al Oficio de Asignación">
                </span>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="objeto">
                    Para qué se requiere:
                </label>
                <div class="col-md-7">
                    <label class="checkbox-inline" for="obj-0">
                        <input class="am-as" id="bestudio_socioeconomico" name="bestudio_socioeconomico" type="checkbox" value="1"/>
                        Estudio Socioeconómico
                    </label>
                    <label class="checkbox-inline" for="obj-1">
                        <input class="am-as" id="bproyecto_ejecutivo" name="bproyecto_ejecutivo" type="checkbox" value="1"/>
                        Proyecto Ejecutivo
                    </label>
                    <label class="checkbox-inline" for="obj-2">
                        <input class="am-as" id="bderecho_via" name="bderecho_via" type="checkbox" value="1"/>
                        Liberación del Derecho de Vía
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <label class="checkbox-inline" for="obj-3">
                        <input class="am-as" id="bimpacto_ambiental" name="bimpacto_ambiental" type="checkbox" value="1"/>
                        Manifestación del Impacto Ambiental
                    </label>
                    <label class="checkbox-inline" for="obj-4">
                        <input class="am-as" id="bobra" name="bobra" type="checkbox" value="1"/>
                        Obra
                    </label>
                    <label class="checkbox-inline" for="obj-5">
                        <input class="am-as" id="baccion" name="baccion" type="checkbox" value="1"/>
                        Acción
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label class="checkbox-inline" for="obj-6">
                                <input class="am-as" id="botro" name="botro" type="checkbox" value="1"/>
                                Otro
                            </label>
                        </div>
                        <div class="col-md-6" hidden="true" id="otro">
                            <input class="form-control input-md am-as" id="descripcion_botro" name="descripcion_botro" placeholder="" type="text"/>
                        </div>
                    </div>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Marcar el cuadro(s) que corresponda al 
                      propósito que se pretenda dar al presupuesto solicitado.">
                </span>
            </div>
            <div class="row form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="ejercicio">
                    <font color="red" size="2">
                        *
                    </font>
                    Ejercicio:
                </label>
                <div class="col-md-2">
                    <select class="form-control obligatorio" id="ejercicio" name="ejercicio">
                        @foreach($ejercicios as $ejercicio)
                        <option value="{{$ejercicio->Ejercicio}}">
                            {{$ejercicio->Ejercicio}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="nombre_obra">
                    <font color="red" size="2">
                        *
                    </font>
                    Nombre de la obra:
                </label>
                <div class="col-md-7">
                    <textarea class="form-control obligatorio" id="nombre_obra" name="nombre_obra" rows="2"></textarea>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar la denominación de la obra oacción, de tal manera que permita identificar con claridad los trabajos a realizar y suubicación.">
                </span>
            </div>
            <div id="depnoruni">
                <div class="row form-group">
                    <label class="col-md-3 col-md-offset-1 control-label" for="ue">
                        Unidad Ejecutora:
                    </label>
                    <div class="col-md-7" id="ue0">
                        <input class="form-control" id="unidad_ejecutora" name="unidad_ejecutora" type="text" value="{{$ue['nombre']}}">
                            <input class="form-control" id="id_unidad_ejecutora" name="id_unidad_ejecutora" type="hidden" value="{{$ue['id']}}">
                            </input>
                        </input>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Unidad Administrativa de acuerdo al
                      Catálogo de Centros de Costo, a nivel jerárquico de una Dirección General
                      o de un Organismo Auxiliar (Organismo Descentralizado, Empresa de Participación Estatal
                      y Fideicomiso Público) que estará a cargo directo del desarrollo del plan,
                      programa o acción.">
                    </span>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 col-md-offset-1 control-label" for="ur">
                        Sector:
                    </label>
                    <div class="col-lg-7" id="ur0">
                        <input class="form-control" id="sector" name="sector" type="text" value="{{$sector['nombre']}}">
                            <input class="form-control" id="id_sector" name="id_sector" type="hidden" value="{{$sector['id']}}">
                            </input>
                        </input>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Secretaría de acuerdo a su
                      denominación en la Ley Orgánica de la Administración Pública, de la
                      Consejería Jurídica, Procuraduría General de Justicia o del Órgano
                      Autónomo, a la cual este adscrita la Unidad Ejecutora y quien tendrá la
                      responsabilidad de coordinar y evaluar su desempeño en el ejercicio del presupuesto asignado.">
                    </span>
                </div>
            </div>
            <div id="accfed">
                <div class="row form-group">
                    <label class="col-lg-3 col-md-offset-4 control-label">
                        Acciones de Gobierno Federal
                    </label>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la(s) opción(es) de tres
                    letras, tres números y texto completo que identifican la(s) Acción(es) de Gobierno.">
                    </span>
                </div>
                <div id="mult">
                    <div class="panel-body">
                        <div class="col-sm-12" id="aF">
                            <select class="form-control input-md" id="accion_federal" multiple="multiple" name="accion_federal[]">
                                @foreach($accionesFederales as $accionFederal)
                                <option value="{{$accionFederal->id}}">
                                    {{$accionFederal->clave}} {{$accionFederal->nombre}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-lg-3 col-md-offset-4 control-label">
                    Acciones de Gobierno Estatal
                </label>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la(s) opción(es) de tres
                letras, tres números y texto completo que identifican la(s) Acción(es) de Gobierno.">
                </span>
            </div>
            <div id="mult">
                <div class="panel-body">
                    <div class="col-sm-12" id="aE">
                        <select class="form-control input-md" id="accion_estatal" multiple="multiple" name="accion_estatal[]">
                            @foreach($accionesEstatales as $accionEstatal)
                            <option value="{{$accionEstatal->id}}">
                                {{$accionEstatal->clave}} {{$accionEstatal->nombre}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="justificacion_obra">
                    <font color="red" size="2">
                        *
                    </font>
                    Justificación de la obra:
                </label>
                <div class="col-md-7">
                    <textarea class="form-control obligatorio" id="justificacion_obra" name="justificacion_obra" rows="2"></textarea>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="modalidad">
                    <font color="red" size="2">
                        *
                    </font>
                    Modalidad de ejecución:
                </label>
                <div class="col-md-2">
                    <select class="form-control obligatorio" id="id_modalidad_ejecucion" name="id_modalidad_ejecucion">
                        <option value="">
                            Seleccione...
                        </option>
                        <option value="1">
                            Contrato
                        </option>
                        <option value="2">
                            Administración
                        </option>
                    </select>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la opción 'Contrato' en el
                caso de que la ejecución de una obra o la prestación de un servicio se encomienden a
                una empresa; de igual manera la modalidad será por contrato, cuando se trate de la
                adquisición de un bien o servicio. Seleccionar la opción 'Administración' cuando la obra
                o acción se realice por la Unidad Ejecutora, siempre y cuando cuente con los recursos humanos,
                materiales y técnicos conforme a los lineamientos establecidos en el Libro D&eécimo
                Segundo del Código Administrativo y en su Reglamento. En este sentido deberá anexarse al
                Expediente, la información que sustente esta condición.">
                </span>
            </div>
            <div class="row form-group">
                <label class="col-md-3 col-md-offset-1 control-label" for="id_tipo_obra">
                    <font color="red" size="2">
                        *
                    </font>
                    Tipo de obra:
                </label>
                <div class="col-md-2">
                    <select class="form-control obligatorio" id="id_tipo_obra" name="id_tipo_obra">
                        <option value="">
                            Seleccione...
                        </option>
                        <option value="1">
                            Nueva
                        </option>
                        <option value="2">
                            En proceso
                        </option>
                    </select>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar 'Nueva' si la obra se ejecutará
                con presupuesto del presente ejercicio fiscal y el cuadro 'Proceso' si el presupuesto para la
                ejecución de la obra se asignó el año o años anteriores, o si se trata de
                una ampliación o reducción de presupuesto.">
                </span>
            </div>
            <div id="todo">
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="monto">
                        <font color="red" size="2">
                            *
                        </font>
                        Monto de la Inversi&oacuten;:
                    </label>
                    <div class="col-lg-3" id="tres">
                        <input class="form-control text-right obligatorio" id="monto" name="monto" readonly="" type="text"/>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la Fuente de financiamiento para
                        llevar a cabo la obra o acción. En caso de ser más de una fuente, deberá
                        colocar el importe que corresponda a cada una de ellas.">
                    </span>
                </div>
                <div class="form-group ftefederal">
                    <label class="col-lg-3 control-label" id="labelfed">
                        Federal:
                    </label>
                    <div class="col-lg-3">
                        <input class="form-control monfed text-right" name="monto_fuente_federal[]" type="text" value=""/>
                    </div>
                    <!--<div id="catffed">-->
                    <label class="col-lg-1 control-label">
                        Fuente:
                    </label>
                    <div class="col-lg-4">
                        <select class="form-control numftef" name="fuente_federal[]">
                            <option value="">
                                Seleccione...
                            </option>
                            @foreach($fuentesFederal as $fuenteF)
                            <option value="{{$fuenteF->id}}">
                                {{$fuenteF->descripcion}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!--</div>-->
                    <input class="bt_ftefed input-sm" type="button" value="+"/>
                </div>
                <div class="form-group fteestatal">
                    <label class="col-lg-3 control-label" id="labeles">
                        Recursos Fiscales (Estatal):
                    </label>
                    <div class="col-lg-3">
                        <input class="form-control monest text-right" name="monto_fuente_estatal[]" type="text" value=""/>
                    </div>
                    <label class="col-lg-1 control-label">
                        Fuente:
                    </label>
                    <div class="col-lg-4">
                        <select class="form-control numftee" name="fuente_estatal[]">
                            <option value="">
                                Seleccione...
                            </option>
                            @foreach($fuentesEstatal as $fuenteE)
                            <option value="{{$fuenteE->id}}">
                                {{$fuenteE->descripcion}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <input class="bt_fteest input-sm" type="button" value="+"/>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="ejemplo_password_3" id="labelmu">
                        Municipal:
                    </label>
                    <div class="col-lg-3">
                        <input class="form-control monmun text-right" id="monto_municipal" name="monto_municipal" type="text" value=""/>
                    </div>
                    <div id="catfmun">
                        <label class="col-lg-1 control-label">
                            Fuente:
                        </label>
                        <div class="col-lg-4">
                            <input class="form-control numftem" id="fuente_municipal" maxlength="30" name="fuente_municipal" type="text">
                            </input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-3 control-label" for="principales_caracteristicas">
                    <font color="red" size="2">
                        *
                    </font>
                    Principales características:
                </label>
                <div class="col-md-7">
                    <textarea class="form-control obligatorio" id="principales_caracteristicas" name="principales_caracteristicas" rows="2"></textarea>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Describir las principales características
                    de la obra o acción.">
                </span>
            </div>
            <div class="form-group">
                <label class="col-lg-5 control-label">
                    Metas a lograr
                </label>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la unidad de medida que
                    corresponda a la meta que se alcanzará al concluirse la obra o acción.">
                </span>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">
                    <font color="red" size="2">
                        *
                    </font>
                    U. Medida:
                </label>
                <div class="col-lg-3">
                    <select class="form-control obligatorio" id="id_meta" name="id_meta">
                        <option value="">
                            Seleccione...
                        </option>
                        @foreach($metas as $meta)
                        <option value="{{$meta->id}}">
                            {{$meta->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-1">
                    <label class="col-lg-2 control-label">
                        Cantidad:
                    </label>
                </div>
                <div class="col-lg-2">
                    <input class="form-control text-right number-oneDec" id="cantidad_meta" name="cantidad_meta" placeholder="0" type="text">
                    </input>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-5 control-label">
                    Beneficiarios
                </label>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el número de personas
                    beneficiadas con la ejecución de la obra o acción. Asimismo se anotará la
                    unidad de medida que corresponda de acuerdo al catálogo correspondien.">
                </span>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">
                    U. Medida:
                </label>
                <div class="col-lg-3">
                    <select class="form-control" id="id_beneficiario" name="id_beneficiario">
                        <option value="">
                            Seleccione...
                        </option>
                        @foreach($beneficiarios as $beneficiario)
                        <option value="{{$beneficiario->id}}">
                            {{$beneficiario->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-1">
                    <label class="col-lg-2 control-label">
                        Cantidad:
                    </label>
                </div>
                <div class="col-lg-2">
                    <input class="form-control number-int text-right" id="cantidad_beneficiario" name="cantidad_beneficiario" placeholder="0" type="text">
                    </input>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="form-group col-md-10">
    <label class="col-lg-6 control-label">
    </label>
    <h6>
        <font color="red" size="2">
            *
        </font>
        Campos obligatorios.
    </h6>
</div>
<input hidden="true" id="usuuni" name="usuuni"/>
<input hidden="true" id="sig2" name="guar"/>
<input hidden="true" id="rut" name="rut"/>
<input hidden="true" id="valsig" name="valsig"/>
<input hidden="true" id="accionGuardar" name="accion" value="guardadoHoja1EstSoc"/>
<input id="isFM" name="isFM" type="hidden"/>
<input id="idDetFon" name="idDetFon" type="hidden"/>
<div class="modal fade" id="modalFM">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
                <h5 class="modal-title">
                    <b>
                        Selección de proyecto del Fondo Metropolitano
                    </b>
                </h5>
            </div>
            <div class="modal-body">
                <p>
                    Seleccione el proyecto correspondiente al
                    <span id="tipoFM">
                    </span>
                </p>
                <table class="table table-bordered" id="tablaProyectosFM">
                    <thead>
                        <tr>
                            <th>
                                idFte
                            </th>
                            <th>
                                idDetFon
                            </th>
                            <th>
                                Clave del proyecto
                            </th>
                            <th>
                                Nombre del proyecto
                            </th>
                            <th>
                                Monto disponible
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <input id="indexTableFM" type="hidden"/>
            </div>
            <div class="modal-footer">
                <span class="btn btn-default" data-dismiss="modal" type="button">
                    Cancelar
                </span>
                <span class="btn btn-primary" id="btnAceptarFM" type="button">
                    Aceptar
                </span>
            </div>
        </div>
    </div>
</div>
