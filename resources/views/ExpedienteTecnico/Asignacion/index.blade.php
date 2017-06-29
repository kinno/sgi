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
<div class="panel">
    <div class="row">
        <input id="hojaActual" name="hojaActual" type="hidden" value="1">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="active" id="panel1">
                    <a data-toggle="tab" href="#h1" role="tab">
                        Hoja 1
                    </a>
                </li>
                <li id="panel2">
                    <a data-toggle="tab" href="#h2" role="tab">
                        Hoja 2
                    </a>
                </li>
                <li id="panel3">
                    <a data-toggle="tab" href="#h3" role="tab">
                        Hoja 3
                    </a>
                </li>
                <li id="panel4">
                    <a data-toggle="tab" href="#h4" role="tab">
                        Hoja 4
                    </a>
                </li>
                <li id="panel5">
                    <a data-toggle="tab" href="#h5" role="tab">
                        Hoja 5
                    </a>
                </li>
                <li id="panel6">
                    <a data-toggle="tab" href="#h6" role="tab">
                        Hoja 6
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="h1">
                    <div class="content">
                        @include('ExpedienteTecnico/Asignacion.hoja1_expediente_tecnico')
                    </div>
                </div>
                <div class="tab-pane " id="h2">
                    <div class="content">
                        @include('ExpedienteTecnico/Asignacion.hoja2_expediente_tecnico')
                    </div>
                </div>
                <div class="tab-pane " id="h3">
                    <div class="content">
                        @include('ExpedienteTecnico/Asignacion.hoja3_expediente_tecnico')
                    </div>
                </div>
                <div class="tab-pane " id="h4">
                    <div class="content">
                        @include('ExpedienteTecnico/Asignacion.hoja4_expediente_tecnico')
                    </div>
                </div>
                <div class="tab-pane " id="h5">
                    <div class="content">
                        @include('ExpedienteTecnico/Asignacion.hoja5_expediente_tecnico')
                    </div>
                </div>
                <div class="tab-pane " id="h6">
                    <div class="content">
                        @include('ExpedienteTecnico/Asignacion.hoja6_expediente_tecnico')
                    </div>
                </div>
            </div>
        </input>
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
<script src="{{ asset('js/Expediente_Tecnico/Asignacion/main_expediente_tecnico.js') }}">
</script>
<script src="{{ asset('js/Expediente_Tecnico/Asignacion/hoja1_expediente_tecnico.js') }}">
</script>
<script src="{{ asset('js/Expediente_Tecnico/Asignacion/hoja2_expediente_tecnico.js') }}">
</script>
<script src="{{ asset('js/Expediente_Tecnico/Asignacion/hoja3_expediente_tecnico.js') }}">
</script>
<script src="{{ asset('js/Expediente_Tecnico/Asignacion/hoja4_expediente_tecnico.js') }}">
</script>
<script src="{{ asset('js/Expediente_Tecnico/Asignacion/hoja5_expediente_tecnico.js') }}">
</script>
<script src="{{ asset('js/Expediente_Tecnico/Asignacion/hoja6_expediente_tecnico.js') }}">
</script>
@endsection
