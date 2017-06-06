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
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title text-center">
            <strong>
                Detalle de la Obra
            </strong>
            <input type="hidden" name="id_obra" id="id_obra">
        </h3>
    </div>
    <div class="panel-body form form-horizontal">
        <div class="row form-group form-group-sm col-md-12">
            <label class="col-md-2 control-label" for="nosolicitud">
                Solicitud Actual:
            </label>
            <div class="col-md-2">
                <input class="form-control input-sm enc" id="id_solicitud_presupuesto" name="id_solicitud_presupuesto" placeholder="" readonly="true" type="text">
                </input>
            </div>
            <label class="col-md-1 control-label" for="encejercicio">
                Ejercicio:
            </label>
            <div class="col-md-1">
                <input class="form-control input-sm enc" id="ejercicio" name="ejercicio" placeholder="" readonly="true" type="text">
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
    </div>
    <div class="panel-footer">
        <span class="btn btn-success btn-sm col-md-offset-4" id="btnVerContratos" style="display: none;">
            Ver/Registrar Contratos
        </span>
        <span class="btn btn-success btn-sm" id="btnGenerarAutorizacion" >
            Generar Autorización
        </span>
    </div>
</div>
<script src="{{ asset('js/Expediente_Tecnico/Autorizacion/main_autorizacion_expediente.js') }}">
</script>
@endsection
