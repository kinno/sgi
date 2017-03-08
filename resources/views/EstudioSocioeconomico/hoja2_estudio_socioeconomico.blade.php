{{--
<link href="contenido_SGI/view/css/fileuploader.css" rel="stylesheet">
    --}}
    <form class="form-horizontal" role="form">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">
                    <strong>
                        HOJA 2
                    </strong>
                </h1>
            </div>
            <div class="panel-body">
                <div class="form-group col-md-10" id="tipcob1">
                    <label class="col-md-4 control-label" for="ejercicio">
                        <font color="red" size="2">
                            *
                        </font>
                        Tipo de Cobertura:
                    </label>
                    <div class="col-md-3">
                        <select class="form-control bnc am-as obligatorioHoja2 obligatorio" id="tipoCobertura" name="tipoCobertura1">
                            <option value="">
                                Seleccione...
                            </option>
                            @foreach($coberturas as $cobertura)
                            <option value="{{$cobertura->IdCob}}">
                                {{$cobertura->NomCob}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la cobertura y el nombre del
              municipio(s) o región(es) donde se llevará a cabo la obra o acción.">
                    </span>
                </div>
                <div hidden="hidden" id="mult1">
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <select class="bnc am-as" id="disponiblesCobertura" multiple="multiple" name="disponiblesCobertura[]">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-10 " hidden="true" id="comloc">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="inputEmail3">
                            Localidad:
                        </label>
                        <div class="col-md-5">
                            <input class="form-control bnc am-as" id="inputEmail3" maxlength="255" name="inputEmail3" type="text">
                            </input>
                        </div>
                        <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el nombre de la(s) localidad(es)
                  donde se llevará a cabo la obra o acción.">
                        </span>
                    </div>
                </div>
                <div class="form-group col-md-10">
                    <label class="col-md-4 control-label" for="idTipLoc">
                        <font color="red" size="2">
                            *
                        </font>
                        Tipo de Localidad:
                    </label>
                    <div class="col-md-3">
                        <select class="form-control bnc am-as obligatorioHoja2 obligatorio" id="tipLoc" name="tipLoc">
                            <option value="">
                                Seleccione...
                            </option>
                            @foreach($localidades as $localidad)
                            <option value="{{$localidad->idTipLoc}}">
                                {{$localidad->NomTipLoc}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-10">
                    <label class="col-lg-4 control-label" for="coord">
                        <font color="red" size="2">
                            *
                        </font>
                        Coordenadas:
                    </label>
                    <div class="col-lg-2">
                        <select class="form-control bnc am-as obligatorioHoja2 obligatorio" id="coor" name="coor">
                            <option value="-1">
                                Seleccionar...
                            </option>
                            <option value="1">
                                Si
                            </option>
                            <option value="2">
                                No aplica
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-5">
                        <input class="form-control bnc am-as" id="obscoor" maxlength="100" name="obscoor" readonly="" type="text">
                            <div id="label3">
                            </div>
                        </input>
                    </div>
                </div>
                <div hidden="true" id="coordenadas">
                    <div class="form-group">
                        <label class="col-lg-6 control-label">
                            Coordenadas Inicio
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">
                            <font color="red" size="2">
                                *
                            </font>
                            LAT:
                        </label>
                        <div class="col-md-3">
                            <input class="form-control text-right corde bnc am-as" id="lat" name="lat" placeholder="0.00" type="text">
                            </input>
                        </div>
                        <label class="col-md-2 control-label">
                            <font color="red" size="2">
                                *
                            </font>
                            LON:
                        </label>
                        <div class="col-md-3">
                            <input class="form-control text-right corde bnc am-as" id="lon" name="lon" placeholder="0.00" type="text">
                            </input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-6 control-label">
                            Coordenadas Final
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">
                            LAT:
                        </label>
                        <div class="col-md-3">
                            <input class="form-control text-right corde bnc am-as" id="lat2" name="lat2" placeholder="0.00" type="text">
                            </input>
                        </div>
                        <label class="col-md-2 control-label">
                            LON:
                        </label>
                        <div class="col-md-3">
                            <input class="form-control text-right corde bnc am-as" id="lon2" name="lon2" placeholder="0.00" type="text">
                            </input>
                        </div>
                    </div>
                    <div class="form-group col-md-10">
                        <label class="col-lg-6 control-label">
                        </label>
                        <center>
                            <h6>
                                Las coordenadas del Estado de México se encuentran entre: (18.4999999,-100.7999999) y (20.39999999,-98.6999999) Latitud y Longitud
                            </h6>
                        </center>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label" for="Mapa">
                            Mapa:
                        </label>
                        <div class="col-md-10">
                            <div id="map">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-10">
                        <label class="col-lg-6 control-label">
                        </label>
                        <center>
                            <h6>
                                Las coordenadas finales solo se capturan para proyectos carreteros, de agua, electrificación entre otros.
                            </h6>
                        </center>
                    </div>
                </div>
                <div class="form-group col-md-10">
                    <label class="col-md-4 control-label" for="microlocalizacion">
                        Microlocalización:
                    </label>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Descripción gráfica y
              detallada de la ubicación de una obra, nivel de localidad, considerando al menos los
              accesos principales y referencias particulares. De ser el caso, se incluirán los nombres
              de las calles que la circundan.">
                    </span>
                    <div class="col-md-7">
                        <div class="col-md-7">
                            <div id="imgPrev">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="bnc am-as" id="microlocalizacion">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-10">
                    <div class="form-group col-md-5">
                    </div>
                    <label class="col-lg-6 control-label">
                    </label>
                    <h6>
                        <b>
                            Tamaño máximo de la imagen: 2MB
                        </b>
                    </h6>
                </div>
                <div class="form-group col-md-10">
                    <label class="col-md-4 control-label" for="nomobra">
                        Nombre del Responsable:
                    </label>
                    <div class="col-md-7">
                        <input class="form-control input-md" id="nomresp" name="nomresp" type="text">
                        </input>
                    </div>
                </div>
                <div class="form-group col-md-10">
                    <label class="col-md-4 control-label" for="nomobra">
                        Cargo del Responsable:
                    </label>
                    <div class="col-md-7">
                        <input class="form-control input-md" id="cargo" name="cargo" type="text">
                        </input>
                    </div>
                </div>
                <div class="form-group col-md-10">
                    <label class="col-md-4 control-label" for="nomobra">
                        Teléfono del Responsable:
                    </label>
                    <div class="col-md-7">
                        <input class="form-control input-md" id="telresp" name="telresp" onkeypress="return justNumbers(event);" type="text">
                        </input>
                    </div>
                </div>
                <div class="form-group col-md-10">
                    <label class="col-md-4 control-label" for="nomobra">
                        Correo electrónico del Responsable:
                    </label>
                    <div class="col-md-7">
                        <input class="form-control input-md" id="emailresp" name="emailresp" type="text">
                        </input>
                    </div>
                </div>
                <div aria-hidden="true" aria-labelledby="basicModal" class="modal fade" id="modalImagen" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                    x
                                </button>
                                <br>
                                </br>
                            </div>
                            <div class="modal-body" id="infoBody">
                                <div style="width:870px; height:550px; overflow: scroll;">
                                    <center>
                                        <img id="imgOriginal"/>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-10">
                    <div class="form-group col-md-1">
                    </div>
                    <label class="col-lg-6 control-label">
                    </label>
                    <h6>
                        <font color="red" size="2">
                            *
                        </font>
                        Campos obligatorios.
                    </h6>
                </div>
                <input hidden="true" id="listcob" name="listcob"/>
            </div>
        </div>
    </form>
</link>