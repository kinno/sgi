@extends('layouts.master')
@section('content')
<link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css"/>

<style type="text/css">
    .details-table tr:first-child td{
        font-weight: bold;
        font-size: 10px;
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
        text-align: right !important;
    }
    .shown{
        background-color: #C8EDAE;
    }

    .main{
        font-size: 12px !important;
        text-align: center;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        {{-- <h3 class="panel-title">
            <strong>
                Nuevos:
            </strong>
            <strong id="total">
            </strong>
        </h3> --}}
        <center>
            <h3 class="panel-title">
                <strong>
                    Revisión de Expediente Técnico
                </strong>
            </h3>
        </center>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <div id="conbco">
                <table class="table table-bordered main" id="tablaExpedientes">
                    <thead>
                        <tr>
                            <th style="width: 5%">
                                Folio Expediente
                            </th>
                            <th style="width: 20%">
                                Obra
                            </th>
                            <th style="width: 20%">
                                Unidad Ejecutora
                            </th>
                            <th style="width: 10%">
                                Fecha Envío
                            </th><th style="width: 10%">
                                Tipo de Solicitud
                            </th>
                            <th class="number-int" style="width: 10%">
                                Monto
                            </th>
                            <th style="width: 5%">
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
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.js"></script>
<script type="text/javascript" src="/js/Expediente_Tecnico/revision_expediente.js"></script>
@endsection
