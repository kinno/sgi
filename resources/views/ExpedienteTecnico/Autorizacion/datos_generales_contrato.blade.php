<form class="form-horizontal" id="form_general" role="form">
    {{ csrf_field() }}
<div class="row form-group" id="rowConceptos">
    <div class="col-md-12 panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                Datos generales del contrato
            </div>
            <div class="panel-body">
                <div class="row form-group">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Número:
                            </span>
                            <input aria-describedby="basic-addon1" class="form-control obligatorioHoja4" id="numero_contrato" name="numero_contrato" placeholder="" type="text" value="{{$contrato->numero_contrato or ''}}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                F. de celebración:
                            </span>
                            <input class="form-control fechaHoja4 obligatorioHoja4 fecha" id="fecha_celebracion" name="fecha_celebracion" placeholder="" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
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
                        <textarea class="form-control obligatorioHoja4" id="descripcion" name="descripcion" placeholder=""></textarea>
                    </div>
                </div>
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
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Unidad Ejecutora u organismo:
                            </span>
                            <span class="form-control" id="unidad_ejecutora" readonly="true">
                            {{$relacion->obra->unidad_ejecutora->nombre}}
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
                            <select class="form-control obligatorioHoja4" id="id_tipo_contrato" name="id_tipo_contrato">
                                <option value="">Seleccione</option>
                                @foreach ($tipo_contrato as $element)
                                <option value="{{$element->id}}">{{$element->nombre}}</option>
                                @endforeach
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
                            <span class="form-control" id="clave_oficio" readonly="true">
                            {{$relacion->obra->detalles_oficio[0]->oficio->clave}}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Fecha de oficio de asignación:
                            </span>
                            <span class="form-control" id="fecha_oficio" readonly="true">
                            {{$relacion->obra->detalles_oficio[0]->oficio->fecha_oficio}}
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
                            <select class="form-control obligatorioHoja4" id="id_modalidad_adjudicacion_contrato" name="id_modalidad_adjudicacion_contrato">
                                <option value="">Seleccione</option>
                                @foreach ($modalidad_adjudicacion as $element)
                                <option value="{{$element->id}}">{{$element->modalidad}}</option>
                                @endforeach
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
                            <span class="form-control" id="id_obra" readonly="true">
                            {{$relacion->obra->id}}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Nombre de obra:
                            </span>
                            <span class="form-control" id="nombre_obra" readonly="true" style="overflow-y: auto;">
                            {{$relacion->obra->nombre}}
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
                            <span class="form-control" id="cobertura" readonly="true">
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
                        <span id="descripcion_obra">{{nl2br($relacion->obra->caracteristicas)}}</span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Monto del contrato (incluye IVA):
                            </span>
                            <input class="form-control numero2 number" id="monto" name="monto" readonly="true" type="text" value="0.00" />
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
                                            <input class="form-control fechaHoja4 obligatorioHoja4 fecha" id="fecha_inicio" name="fecha_inicio" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">
                                                Fecha de término:
                                            </span>
                                            <input class="form-control fechaHoja4 obligatorioHoja4 fecha" id="fecha_fin" name="fecha_fin" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Días calendario:
                                            </span>
                                            <input class="form-control" id="dias_calendario" name="dias_calendario" readonly="true" type="text"/>
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
                            <select class="form-control obligatorioHoja4" id="bdisponibilidad_inmueble" name="bdisponibilidad_inmueble">
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
                            <textarea class="form-control obligatorioHoja4" id="motivo_no_disponible" name="motivo_no_disponible"></textarea>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Fecha de disponibilidad:
                            </span>
                            <input class="form-control fechaHoja4 obligatorioHoja4 fecha" id="fecha_disponibilidad" name="fecha_disponibilidad" readonly="true" style="background-color: white !important; cursor: pointer !important;" type="text"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Tipo de obra (contrato):
                            </span>
                            <select class="form-control obligatorioHoja4" id="id_tipo_obra_contrato" name="id_tipo_obra_contrato">
                                <option value="">Seleccione</option>
                                @foreach ($tipo_obra_contrato as $element)
                                     <option value="{{$element->id}}">{{$element->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
{{-- {{dd($relacion)}} --}}