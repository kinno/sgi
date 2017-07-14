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
                    Listado de Autorizaciones de Pago
                </strong>
            </h3>
        </center>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <div id="conbco">
                <table class="table table-bordered main" id="tablaAp">
                    <thead>
                        <tr>
                            <th style="width: 0%">
                                id
                            </th>
                            <th style="width: 10%">
                                Obra
                            </th>
                            <th>
                                Folio A. P.
                            </th>
                            <th style="width: 10%">
                                Tipo
                            </th>
                            <th class="number-int" style="width: 10%">
                                Monto
                            </th>
                            <th class="number-int" style="width: 10%">
                                Estatus
                            </th>
                            <th style="width: 5%">
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
    </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="modalDetalle" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
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
                    Detalle Autorización de Pago
                </h4>
            </div>
            <div class="modal-body" id="divDetalle">
                {{-- @include('AutorizacionPago/listado_detalle_ap') --}}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.js"></script>
<script type="text/javascript" src="/js/AutorizacionPago/listado_autorizacion_pago.js"></script>
@endsection
