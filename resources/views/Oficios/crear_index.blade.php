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
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title text-center">
            <strong>
                Creación de Oficios
            </strong>
        </h3>
    </div>
    <input type="hidden" name="id_oficio" id="id_oficio">
    <div class="panel-body" id="infoGralChild">
        <div class="form-horizontal">
            <div class="form-group form-group-sm">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-2 control-label">
                            Tipo de Solicitud:
                        </label>
                        <div class="col-md-4">
                            <select class="form-control" id="id_tipo_solicitud" name="id_tipo_solicitud">
                                @foreach ($tipoSolicitud as $element)
                                <option value="{{$element->id}}">
                                    {{$element->nombre}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-1 control-label">
                            Ejercicio:
                        </label>
                        <div class="col-md-2">
                            <select class="form-control" id="ejercicio" name="ejercicio">
                                @foreach ($ejercicios as $element)
                                <option value="{{$element->ejercicio}}">
                                    {{$element->ejercicio}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-1 control-label">
                            Obra:
                        </label>
                        <div class="col-md-1">
                            <input aria-describedby="basic-addon1" class="form-control input-sm numero" id="id_obra" name="id_obra" placeholder="0" type="text"/>
                            <input type="hidden" id="id_sector" name="id_sector" value=""/>
                            <input type="hidden" id="id_sector_tmp" name="id_sector_tmp" value=""/>
                            <input type="hidden" id="id_unidad_ejecutora" name="id_unidad_ejecutora" value=""/>
                            <input type="hidden" id="id_unidad_ejecutora_tmp" name="id_unidad_ejecutora_tmp" value=""/>
                        </div>
                        <div class="col-md-10">
                            <input class="form-control" id="nombre_obra" name="nombre_obra" readonly="" type="text" value=""/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-2 control-label">
                            Unidad Ejecutora:
                        </label>
                        <div class="col-md-10">
                            <select class="form-control" id="id_unidad_ejecutora_select" name="id_unidad_ejecutora_select">
                                <option></option>
                                @foreach ($unidad_ejecutora as $element)
                                    <option value="{{$element->id}}">{{$element->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div id="divFuentes">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover table-condensed" id="tablaFuentes" style="font-size: 11px;">
                            <thead>
                                <tr>
                                    <th style="width:15px;">
                                    <input type="checkbox" id="checkAll" class="form-control" />
                                    </th>
                                    <th style="display: none;">
                                        idFte
                                    </th>
                                    <th>
                                        Fuente
                                    </th>
                                    <th>
                                        Tipo
                                    </th>
                                    <th>
                                        Cuenta
                                    </th>
                                    <th style="text-align:right;">
                                        Monto
                                    </th>
                                    <th>
                                        Partida Presupuestal
                                    </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <div class="pull-right">
                                            <button class="btn btn-success btn-sm" id="btnAgregar" type="button">
                                                Agregar
                                                <i aria-hidden="true" class="fa fa-level-down">
                                                </i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="active" id="panel1">
                    <a data-toggle="tab" href="#h1" role="tab">
                        Detalle del Oficio
                    </a>
                </li>
                <li id="panel2">
                    <a data-toggle="tab" href="#h2" role="tab">
                        Texto del Oficio
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="h1">
                    <div class="content">
                        @include('Oficios.detalle_oficio')
                    </div>
                </div>
                <div class="tab-pane " id="h2">
                    <div class="content">
                        @include('Oficios.detalle_textos')
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
<script src="{{ asset('js/Oficios/main_oficios.js') }}">
</script>
@endsection
