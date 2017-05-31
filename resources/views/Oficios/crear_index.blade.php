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
                        </div>
                        <div class="col-md-10">
                            <input class="form-control" id="nombre_obra" name="nombre_obra" readonly="" type="text" value=""/>
                        </div>
                    </div>
                </div>
            </div>
            <div id="divFuentes">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="tablaFuentes" style="font-size: 11px;">
                            <thead>
                                <tr>
                                    <th>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <strong>
                        Obras en el Oficio
                    </strong>
                </h3>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row form-group">
                        <table class="table table-bordered" id="tablaObras" style="font-size: 11px;">
                            <thead>
                                <tr>
                                    <th>
                                        id_det_ofi
                                    </th>
                                    <th>
                                        No. Obra
                                    </th>
                                    <th>
                                        id_tipo_solicitud
                                    </th>
                                    <th>
                                        Solicitud
                                    </th>
                                    <th>
                                        id_fuente
                                    </th>
                                    <th>
                                        Fuente
                                    </th>
                                    <th>
                                        Monto
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <strong>
                        Texto del Oficio
                    </strong>
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="form_anexo_uno" role="form">
                {{csrf_field()}}
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-2 control-label">
                                    Fuente:
                                </label>
                                <div class="col-md-9">
                                    <select class="form-control" id="id_fuente" name="id_fuente">
                                    <option value="">Selecciona...</option>
                                    @foreach ($fuentes as $fuente)
                                        <option value="{{$fuente->id}}">{{$fuente->descripcion}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-2 col-md-offset-8 control-label">
                                    Fecha del oficio:
                                </label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control input-sm" name="fecha_oficio" id="fecha_oficio" readonly value="{{Carbon\Carbon::now()->format('d-m-Y')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Titular:
                                        </span>
                                        <textarea class="form-control" id="titular" name="titular"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-offset-1">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Asunto:
                                        </span>
                                        <textarea class="form-control" id="asunto" name="asunto"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            C.c.p:
                                        </span>
                                        <textarea class="form-control" id="ccp" name="ccp" rows="8"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-offset-1">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Prefijo:
                                        </span>
                                        <input class="form-control" id="prefijo" name="prefijo" type="text">
                                        </input>
                                    </div>
                                </div>
                                {{--
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Referencia:
                                        </span>
                                        <input class="form-control" id="referencia" name="referencia" type="text">
                                        </input>
                                    </div>
                                </div>
                                --}}
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            T.A.T.:
                                        </span>
                                        <input class="form-control" id="tarjeta_turno" name="tarjeta_turno" type="text">
                                        </input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-offset-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Referencia:
                                        </span>
                                        <input class="form-control" id="iniciales" name="iniciales" type="text" value="{{$iniciales}}">
                                        </input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-10 col-md-offset-1">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Texto:
                                        </span>
                                        <textarea class="form-control" id="texto" name="texto" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-offset-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Referencia:
                                        </span>
                                        <input class="form-control" id="iniciales" name="iniciales" type="text">
                                        </input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </form>
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
