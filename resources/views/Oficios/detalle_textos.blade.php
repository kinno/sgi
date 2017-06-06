<div class="panel panel-default">
    {{-- <div class="panel-heading">
        <h3 class="panel-title">
            <strong>
                Texto del Oficio
            </strong>
        </h3>
    </div> --}}
    <div class="panel-body">
        <form class="form-horizontal" id="form_anexo_uno" role="form">
            {{csrf_field()}}
            <div class="form-group form-group-sm">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label class="col-md-1 control-label">
                                Fuente:
                            </label>
                            <div class="col-md-11">
                                <select class="form-control" id="id_fuente" name="id_fuente">
                                    <option value="">
                                        Selecciona...
                                    </option>
                                    @foreach ($fuentes as $fuente)
                                    <option value="{{$fuente->id}}">
                                        {{$fuente->descripcion}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-1 ">
                            <button class="btn btn-success btn-sm" id="btnTextos" type="button">
                            <i aria-hidden="true" class="fa fa-align-left">
                                </i>
                                Cargar textos
                            </button>
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
                            <input class="form-control input-sm" id="fecha_oficio" name="fecha_oficio" readonly="" type="text" value="{{Carbon\Carbon::now()->format('d-m-Y')}}">
                            </input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    Titular:
                                </span>
                                <textarea class="form-control" id="titular" name="titular" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 ">
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
                        <div class="col-sm-3 col-md-offset-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    Prefijo:
                                </span>
                                <input class="form-control" id="prefijo" name="prefijo" type="text">
                                </input>
                            </div>
                        </div>
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
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    Texto:
                                </span>
                                <textarea class="form-control" id="texto" name="texto" rows="13"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    C.c.p:
                                </span>
                                <textarea class="form-control" id="ccp" name="ccp" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    Referencia:
                                </span>
                                <input class="form-control" id="iniciales" name="iniciales" type="text" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>