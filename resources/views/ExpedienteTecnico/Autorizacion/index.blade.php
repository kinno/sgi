@extends('layouts.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<link href="/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="/css/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css"/>
<script src="/js/jquery.dataTables.min.js" type="text/javascript">
</script>
<script src="/js/dataTables.bootstrap.min.js" type="text/javascript">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-filestyle/1.2.1/bootstrap-filestyle.js">
</script>
<script src="/js/jquery.bootstrap-touchspin.js">
</script>
<style type="text/css">
    .notifyjs-foo-base {
  opacity: 0.85;
  width: 200px;
  background: #F5F5F5;
  padding: 5px;
  border-radius: 10px;
}

.notifyjs-foo-base .title {
  width: 100px;
  float: left;
  margin: 10px 0 0 10px;
  text-align: right;
}

.notifyjs-foo-base .buttons {
  width: 70px;
  float: right;
  font-size: 9px;
  padding: 5px;
  margin: 2px;
}

.notifyjs-foo-base button {
  font-size: 9px;
  padding: 5px;
  margin: 2px;
  width: 60px;
}
</style>
<div class="panel panel-default" id="principal">
    <div class="panel-heading">
        <h3 class="panel-title text-center">
            <strong>
                Solicitud de Autorización
            </strong>
            <input type="hidden" name="id_obra" id="id_obra">
            <input type="hidden" name="id_expediente_tecnico" id="id_expediente_tecnico">
        </h3>
    </div>
    <div class="panel-body form form-horizontal">
        <div class="row form-group form-group-sm col-md-12">
            <label class="col-md-2 control-label" for="nosolicitud">
                Obra:
            </label>
            <div class="col-md-2">
                <input class="form-control input-sm enc" id="id_obra_search" name="id_obra_search" placeholder="" type="text" value="{{$id_obra}}">
                </input>
            </div>
            <label class="col-md-1 control-label" for="encejercicio">
                Ejercicio:
            </label>
            <div class="col-md-2">
                <select class="form-control" id="ejercicio">
                    @foreach ($ejercicios as $value)
                        <option value="{{$value->ejercicio}}">{{$value->ejercicio}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <span class="btn btn-default btn-sm fa fa-search" id="buscar"></span>
            </div>
        </div>
        <div class="row form-group form-group-sm col-md-12">
            <label class="col-md-2 control-label" for="nosolicitud">
                Solicitud Actual:
            </label>
            <div class="col-md-2">
                <input class="form-control input-sm enc" id="id_solicitud_presupuesto" name="id_solicitud_presupuesto" placeholder="" readonly="true" type="text">
                </input>
            </div>
            
            <label class="col-md-2 control-label" for="encmonto">
                Monto Asignado:
            </label>
            <div class="col-md-3">
                <input class="form-control input-sm number enc" id="monto" name="monto" placeholder="" readonly="true" type="text">
                </input>
            </div>
        </div>
        <div class="row form-group form-group-sm col-md-12">
            <label class="col-md-2 control-label" for="encnomobr">
                Nombre de la Obra:
            </label>
            <div class="col-md-9">
                <textarea class="form-control input-sm enc" id="nombre_obra" name="nombre_obra" placeholder="" readonly="true">
                </textarea>
            </div>
        </div>
        <div class="row form-group form-group-sm col-md-12">
            <label class="col-md-2 control-label" for="encue">
                Unidad Ejecutora:
            </label>
            <div class="col-md-9">
                <input class="form-control input-sm enc" id="unidad_ejecutora" name="unidad_ejecutora" placeholder="" readonly="true" type="text">
                </input>
            </div>
        </div>
        <div class="row form-group form-group-sm col-md-12">
            <label class="col-md-3 control-label" for="encur">
                Sector:
            </label>
            <div class="col-md-8">
                <input class="form-control input-sm enc" id="sector" name="sector" placeholder="" readonly="true" type="text">
                </input>
            </div>
        </div>
        <div class="row form-group form-group-sm col-md-12">
            <label class="col-md-3 control-label" for="encmodeje">
                Modalidad de Ejecución:
            </label>
            <div class="col-md-3">
                <input class="form-control input-sm enc" id="modalidad_ejecucion" name="modalidad_ejecucion" readonly="true" type="text">
                </input>
            </div>
            <label class="col-md-2 control-label" for="enctipobr">
                Tipo de Obra:
            </label>
            <div class="col-md-3">
                <input class="form-control input-sm enc" id="tipo_obra" name="tipo_obra" readonly="true" type="text">
                </input>
            </div>
        </div>
        <div id="listadoContratos" class="row form-group form-group-sm col-md-12" style="display: none" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">
                        <strong>
                            Contratos
                        </strong>
                    </h3>
                </div>
                <div class="panel-body">
                    <hr>
                        <table class="table table-striped table-condensed table-hover" id="tablaContratos" {{-- style="font-size: 0.85em" --}}>
                            <thead>
                                <tr>
                                    <th style="display: none;">
                                        idContrato 0
                                    </th>
                                    <th>
                                        Número de Contrato
                                        <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el 
                                                          número de contrato asignado para la realización de 
                                                          la obra o acción.">
                                        </span>
                                    </th>
                                    <th>
                                        Fecha de celebración
                                    </th>
                                    <th>
                                        Monto
                                        <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el 
                                                          monto total del contrato para realizar la obra o acción.">
                                        </span>
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </hr>
                </div>
                <div class="panel-footer">
                    <span class="btn btn-success btn-sm" id="btnRegistrarContrato" >
                        Registrar Contrato
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer" id="divBotones" style="display: none">
       {{--  <span class="btn btn-success btn-sm col-md-offset-4" id="btnVerContratos" style="display: none;">
            Ver/Registrar Contratos
        </span> --}}
        <span class="btn btn-success btn-sm" id="btnGenerarAutorizacion" >
            Generar Autorización
        </span>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="modal_observaciones" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-warning">
            <div class="modal-header panel-heading">
                <span class="close" data-dismiss="modal">
                    <span aria-hidden="true">
                        ×
                    </span>
                    <span class="sr-only">
                        Close
                    </span>
                </span>
                <h4 class="modal-title" id="myModalLabel">
                    Listado de Observaciones
                </h4>
            </div>
            <div class="modal-body">
                    <table class="table table-bordered" id="tablaObservaciones" style="font-size: 12px; width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 50%">
                                Observaciones
                            </th>
                            <th style="width: 50%">
                                Fecha
                            </th>
                        </tr>
                    </thead>
                </table>
                
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/Expediente_Tecnico/Autorizacion/main_autorizacion_expediente.js') }}">
</script>
@endsection
