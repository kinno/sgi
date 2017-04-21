@extends('layouts.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-filestyle/1.2.1/bootstrap-filestyle.js">
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
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <p class="navbar-text">
                        No. Solcitud:
                    </p>
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input class="form-control text-right num" id="id_expediente_tecnico" name="id_expediente_tecnico" placeholder="Buscar" type="text" value="">
                            </input>
                        </div>
                        <span class="btn btn-default fa fa-search" id="buscar" title="Buscar Solicitud">
                        </span>
                        <span class="btn btn-warning fa fa-refresh" id="limpiar" title="Limpiar pantalla">
                        </span>
                        <span class="btn btn-success fa fa-save" id="guardar" title="Guardar">
                        </span>
                        <span class="btn btn-success fa fa-share-square" id="dictaminar" title="Enviar a la DGI para dictaminar">
                        </span>
                        <span class="btn btn-success fa fa-file-pdf-o" id="ficha_tecnica" title="Imprimir ficha técnica">
                        </span>
                    </form>
                </div>
            </div>
        </nav>
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
                        @include('ExpedienteTecnico.hoja1_expediente_tecnico')
                    </div>
                </div>
                <div class="tab-pane " id="h2">
                    <div class="content">
                        @include('ExpedienteTecnico.hoja2_expediente_tecnico')
                    </div>
                </div>
                <div class="tab-pane " id="h3">
                    <div class="content">
                        @include('ExpedienteTecnico.hoja3_expediente_tecnico')
                    </div>
                </div>
                <div class="tab-pane " id="h4">
                    <div class="content">
                        @include('ExpedienteTecnico.hoja4_expediente_tecnico')
                    </div>
                </div>
                <div class="tab-pane " id="h5">
                    <div class="content">
                        @include('ExpedienteTecnico.hoja5_expediente_tecnico')
                    </div>
                </div>
                <div class="tab-pane " id="h6">
                    <div class="content">
                        @include('ExpedienteTecnico.hoja6_expediente_tecnico')
                    </div>
                </div>
            </div>
        </input>
    </div>
</div>
@endsection
