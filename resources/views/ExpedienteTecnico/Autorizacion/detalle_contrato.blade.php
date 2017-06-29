@extends('layouts.master')
@section('content')
<link href="/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="/css/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css"/>
<script src="/js/jquery.dataTables.min.js" type="text/javascript">
</script>
<script src="/js/dataTables.bootstrap.min.js" type="text/javascript">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-filestyle/1.2.1/bootstrap-filestyle.js">
</script>
<script src="/js/jquery.bootstrap-touchspin.js">
</script>
<input type="text" id="id_obra" value="{{$relacion->obra->id}}"/>
<input type="text" id="id_expediente_tecnico" value="{{$relacion->id_expediente_tecnico}}"/>
<input type="text" id="id_contrato" value="{{($id_contrato!=="0")?$id_contrato:''}}"/>
<input type="text" id="hojaActual" value="1"/>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title text-center">
            <strong>
                Detalle del Contrato
            </strong>
        </h3>
    </div>
    <div class="panel-body">
        <div class="form-group panel-body">
            <div class="row form-group">
                <input id="hojaActual" name="hojaActual" type="hidden" value="1"/>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="active" id="panel1">
                        <a data-toggle="tab" href="#h1" role="tab">
                            Datos Generales
                        </a>
                    </li>
                    <li id="panel2">
                        <a data-toggle="tab" href="#h2" role="tab">
                            Conceptos
                        </a>
                    </li>
                    <li id="panel3">
                        <a data-toggle="tab" href="#h3" role="tab">
                            Garantías
                        </a>
                    </li>
                    <li id="panel4">
                        <a data-toggle="tab" href="#h4" role="tab">
                            Avance Físico
                        </a>
                    </li>
                    <li id="panel5">
                        <a data-toggle="tab" href="#h5" role="tab">
                            Avance Financiero
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="h1">
                        <div class="content">
                            @include('ExpedienteTecnico/Autorizacion.datos_generales_contrato')
                        </div>
                    </div>
                    <div class="tab-pane " id="h2">
                        <div class="content">
                            @include('ExpedienteTecnico/Autorizacion.datos_conceptos')
                        </div>
                    </div>
                    <div class="tab-pane " id="h3">
                        <div class="content">
                            @include('ExpedienteTecnico/Autorizacion.datos_garantias')
                        </div>
                    </div>
                    <div class="tab-pane " id="h4">
                        <div class="content">
                            @include('ExpedienteTecnico/Autorizacion.datos_avance_fisico')
                        </div>
                    </div>
                    <div class="tab-pane " id="h5">
                        <div class="content">
                            @include('ExpedienteTecnico/Autorizacion.datos_avance_financiero')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/Expediente_Tecnico/Autorizacion/main_detalle_contrato.js') }}">
</script>

@endsection
