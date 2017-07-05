<form class="form-horizontal" enctype="”multipart/form-data”" id="form_anexo_dos" role="form">
    {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">
                <strong>
                    ANEXO 2
                    <input id="id_hoja_dos" name="id_hoja_dos" type="hidden">
                        <input id="id_expediente_tecnico" name="id_expediente_tecnico" type="hidden">
                        </input>
                    </input>
                </strong>
            </h1>
        </div>
        <div class="panel-body">
            <div class="form-group form-group-sm col-md-10" id="tipcob1">
                <label class="col-md-4 control-label" for="ejercicio">
                    <font color="red" size="2">
                        *
                    </font>
                    Tipo de Cobertura:
                </label>
                <div class="col-md-3">
                    <select class="form-control input-sm bnc am-as " id="id_cobertura" name="id_cobertura">
                        <option value="">
                            Seleccione...
                        </option>
                        @foreach($coberturas as $cobertura)
                        <option value="{{$cobertura->id}}">
                            {{$cobertura->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la cobertura y el nombre del
                                                                        municipio(s) o región(es) donde se llevará a cabo la obra o acción.">
                </span>
            </div>
            <div class="panel-body" id="divRegiones" style="display:none;">
                <div class="col-sm-12">
                    <select class="form-control input-sm " id="id_region" multiple="multiple" name="id_region[]">
                        @foreach($regiones as $region)
                        <option value="{{$region->id}}">
                            {{$region->clave}} {{$region->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="panel-body" id="divMunicipios" style="display:none;">
                <div class="col-sm-12">
                    <select class="form-control input-sm " id="id_municipio" multiple="multiple" name="id_municipio[]">
                        @foreach($municipios as $municipio)
                        <option value="{{$municipio->id}}">
                            {{$municipio->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group form-group-sm col-md-10 " hidden="true" id="comloc">
                <div class="form-group form-group-sm">
                    <label class="col-md-4 control-label">
                        Localidad:
                    </label>
                    <div class="col-md-5">
                        <input class="form-control input-sm bnc am-as" id="nombre_localidad" name="nombre_localidad" type="text">
                        </input>
                    </div>
                    <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el nombre de la(s) localidad(es)
                  donde se llevará a cabo la obra o acción.">
                    </span>
                </div>
            </div>
            <div class="form-group form-group-sm col-md-10">
                <label class="col-md-4 control-label">
                    <font color="red" size="2">
                        *
                    </font>
                    Tipo de Localidad:
                </label>
                <div class="col-md-3">
                    <select class="form-control input-sm bnc am-as " id="id_tipo_localidad" name="id_tipo_localidad">
                        <option value="">
                            Seleccione...
                        </option>
                        @foreach($localidades as $localidad)
                        <option value="{{$localidad->id}}">
                            {{$localidad->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group form-group-sm col-md-10">
                <label class="col-lg-4 control-label">
                    <font color="red" size="2">
                        *
                    </font>
                    Coordenadas:
                </label>
                <div class="col-lg-2">
                    <select class="form-control input-sm bnc am-as " id="bcoordenadas" name="bcoordenadas">
                        <option value="">
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
                    <input class="form-control input-sm bnc am-as" id="observaciones_coordenadas" maxlength="100" name="observaciones_coordenadas" readonly="" type="text">
                        <div id="label3">
                        </div>
                    </input>
                </div>
            </div>
            <div hidden="true" id="coordenadas">
                <div class="form-group form-group-sm">
                    <label class="col-lg-6 control-label">
                        Coordenadas Inicio
                    </label>
                </div>
                <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">
                        <font color="red" size="2">
                            *
                        </font>
                        LAT:
                    </label>
                    <div class="col-md-3">
                        <input class="form-control input-sm text-right corde bnc am-as" id="latitud_inicial" name="latitud_inicial" placeholder="0.00" type="text">
                        </input>
                    </div>
                    <label class="col-md-2 control-label">
                        <font color="red" size="2">
                            *
                        </font>
                        LON:
                    </label>
                    <div class="col-md-3">
                        <input class="form-control input-sm text-right corde bnc am-as" id="longitud_inicial" name="longitud_inicial" placeholder="0.00" type="text">
                        </input>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <label class="col-lg-6 control-label">
                        Coordenadas Final
                    </label>
                </div>
                <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">
                        LAT:
                    </label>
                    <div class="col-md-3">
                        <input class="form-control input-sm text-right corde bnc am-as" id="latitud_final" name="latitud_final" placeholder="0.00" type="text">
                        </input>
                    </div>
                    <label class="col-md-2 control-label">
                        LON:
                    </label>
                    <div class="col-md-3">
                        <input class="form-control input-sm text-right corde bnc am-as" id="longitud_final" name="longitud_final" placeholder="0.00" type="text">
                        </input>
                    </div>
                </div>
                <div class="form-group form-group-sm col-md-10">
                    <label class="col-lg-6 control-label">
                    </label>
                    <center>
                        <h6>
                            Las coordenadas del Estado de México se encuentran entre: (18.4999999,-100.7999999) y (20.39999999,-98.6999999) Latitud y Longitud
                        </h6>
                    </center>
                </div>
                <div class="form-group form-group-sm col-md-12">
                    <label class="col-md-2 control-label" for="Mapa">
                        Mapa:
                    </label>
                    <div class="col-md-10">
                        <div id="map">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm col-md-10">
                    <label class="col-lg-6 control-label">
                    </label>
                    <center>
                        <h6>
                            Las coordenadas finales solo se capturan para proyectos carreteros, de agua, electrificación entre otros.
                        </h6>
                    </center>
                </div>
            </div>
            <div class="form-group form-group-sm col-md-10">
                <label class="col-md-4 control-label" for="microlocalizacion">
                    Microlocalización:
                </label>
                <span class="glyphicon glyphicon-question-sign ayuda" title="Descripción gráfica y
              detallada de la ubicación de una obra, nivel de localidad, considerando al menos los
              accesos principales y referencias particulares. De ser el caso, se incluirán los nombres
              de las calles que la circundan.">
                </span>
                <div class="col-md-7">
                    <input id="microlocalizacion" name="microlocalizacion" type="file">
                    </input>
                </div>
            </div>
            <div class="form-group form-group-sm col-md-10">
                <div class="form-group form-group-sm col-md-5">
                </div>
                <label class="col-lg-6 control-label">
                </label>
                <h6>
                    <b>
                        Tamaño máximo de la imagen: 2MB
                    </b>
                </h6>
            </div>
            <div class="form-group form-group-sm col-md-12">
                <div class="col-md-4 col-md-offset-3">
                    <img id="vista_previa" style="width:100%;"/>
                </div>
                <div class="col-md-1">
                    <span class="btn btn-danger fa fa-trash" title="Eliminar imagen" id="borrar_imagen"></span>
                </div> 
            </div>
        </div>
    </div>
</form>
