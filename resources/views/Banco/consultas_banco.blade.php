@extends('layouts.master')
@section('content')
<link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css"/>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.js"></script>
<script type="text/javascript" src="/js/Banco/consultas_banco.js"></script>
<style type="text/css">
    .details-table tr:first-child td{
        font-weight: bold;
    }

    .details-table td{
        width: 100px;
        font-size: 12px;
    }

    .comentarios-table{
        font-weight: bold;
        background-color: #C8EDAE !important;
    }

    .negrita{
        font-weight: bold !important;
    }
    .mto{
        text-align: right;
    }
    .shown{
        background-color: #C8EDAE;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">
            <strong>
                Nuevos:
            </strong>
            <strong id="total">
            </strong>
        </h3>
        <center>
            <h3 class="panel-title">
                <strong>
                    Consulta de Banco de Proyectos
                </strong>
            </h3>
        </center>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <div id="conbco">
                <table class="table table-bordered" id="tablaObservaciones">
                    <thead>
                        <tr>
                            <th style="width: 5%">
                                No. Banco
                            </th>
                            <th style="width: 5%">
                                No. Dictaminación
                            </th>
                            <th style="width: 20%">
                                Obra
                            </th>
                            <th style="width: 20%">
                                Unidad Ejecutora
                            </th>
                            <th style="width: 10%">
                                Fecha Movimiento
                            </th>
                            <th style="width: 10%">
                                Estatus
                            </th>
                            <th class="number-int" style="width: 10%">
                                Monto
                            </th>
                            <th style="width: 5%">
                            </th>
                            {{-- <th hidden="true">
                            </th> --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row">
        </div>
        <div class="col-lg-offset-11">
            <span class="btn btn-success" onclick="exportarListado();">
                <span class="glyphicon glyphicon-book">
                </span>
                <span>
                    Exportar
                </span>
            </span>
        </div>
    </div>
</div>
<script id="details-template" type="text/x-handlebars-template">
    <div class="panel panel-success">
      <!-- Default panel contents -->
      <div class="panel-heading">
          <div class="label label-success">Histórico de observaciones del Estducio Socioeconómico: <b>@{{ id }}</b></div>
      </div>
      <!-- Table -->
     <table class="table  details-table" id="movimientos-@{{id}}">
        <thead>
        <tr>
            <th>Evaluación</th>
            <th>Fecha</th>
            <th>Versión del Estudio</th>
            <th>Observaciones generales</th>
            <th></th>
        </tr>
        </thead>
    </table>
    </div>
</script>
<script id="comentarios-template" type="text/x-handlebars-template">
    <div class="panel panel-success">
      <!-- Default panel contents -->
      <div class="panel-heading"><div class="label label-success">Observaciones de la evaluación No. <b>@{{ id_evaluacion }}</b></div></div>
      <!-- Table -->
      <table class="table comentarios-table" id="comentarios-@{{id_evaluacion}}">
            <thead>
            <tr>
                <th>Inciso</th>
                <th>Página</th>
                <th>Observaciones</th>
            </tr>
            </thead>
            <tbody id="comentariosTbody">
            </tbody>
        </table>
    </div>
</script>
@endsection
