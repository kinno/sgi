jQuery(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#panel1").on('click', function() {
        $("#hojaActual").val('1');
    });
    $("#panel2").on('click', function() {
        $("#hojaActual").val('2');
    });
    $("#buscar").on('click', function() {
        buscarEstudio();
    });
    $("#limpiar").on('click', function() {
        location.reload();
    });
    $("#guardar").on('click', function() {
        guardar();
    });
    $("#dictaminar").on('click', function() {
        enviar_dictaminar();
    });
    $("#ficha_tecnica").on('click', function() {
        imprime_ficha_tecnica($("#id_estudio_socioeconomico").val());
    });
    $.notify.addStyle('foo', {
        html: "<div>" + "<div class='clearfix'>" + "<div class='title' data-notify-html='title'/>" + "<div class='buttons'>" + "<button class='no'>Cancelar</button>" + "<button class='yes'>Confirmar</button>" + "</div>" + "</div>" + "</div>"
    });
    //listen for click events from this style
    $(document).on('click', '.notifyjs-foo-base .no', function() {
        //programmatically trigger propogating hide event
        $(this).trigger('notify-hide');
    });
    $(document).on('click', '.notifyjs-foo-base .yes', function() {
        //show button text
        confirm_dictaminar();
        //hide notification
        $(this).trigger('notify-hide');
    });
    $(".navbar-form").submit(function(e) {
        return false;
    });
});

function buscarEstudio() {
    if ($("#id_estudio_socioeconomico").val() != "") {
        $.ajax({
            data: {
                'id_estudio_socioeconomico': $("#id_estudio_socioeconomico").val()
            },
            url: '/EstudioSocioeconomico/buscar_estudio',
            type: 'post',
            beforeSend: function() {
                $("#divLoading").show();
            },
            complete: function() {
                $("#divLoading").hide();
            },
            success: function(response) {
                console.log(response);
                var data = response;
                if (!data.error) {
                    hoja1 = data.hoja1;
                    acuerdos = data.acuerdos;
                    fuentes = data.fuentes_monto;
                    hoja2 = data.hoja2;
                    regiones = data.regiones;
                    municipios = data.municipios;
                    if (data.id) {
                        if (hoja1) {
                            $("#id_hoja_uno").val(hoja1.id);
                            $("#estudio_socioeconomico").val(data.id);
                            $("#ejercicio").val(hoja1.ejercicio);
                            $("#vida_proyecto").val(hoja1.vida_proyecto);
                            $("#nombre_obra").val(hoja1.nombre_obra);
                            $("#unidad_ejecutora").val(hoja1.id_unidad_ejecutora);
                            $("#sector").val(hoja1.id_sector);
                            arrAcuerdos = [];
                            for (var i = 0; i < acuerdos.length; i++) {
                                arrAcuerdos.push(acuerdos[i].id_acuerdo);
                            }
                            $("#accion_federal,#accion_estatal").val(arrAcuerdos).trigger('change');
                            $("#justificacion_obra").val(hoja1.justificacion_obra);
                            $("#id_modalidad_ejecucion").val(hoja1.id_modalidad_ejecucion);
                            $("#id_tipo_obra").val(hoja1.id_tipo_obra);
                            $("#monto").val(hoja1.monto).autoNumeric('update');
                            $("#principales_caracteristicas").val(hoja1.principales_caracteristicas);
                            $("#id_grupo_social").val(hoja1.id_grupo_social);
                            $("#id_meta").val(hoja1.id_meta);
                            $("#cantidad_meta").val(hoja1.cantidad_meta).autoNumeric('update');;
                            // $("#id_beneficiario").val(hoja1.id_beneficiario);
                            $("#cantidad_beneficiario").val(hoja1.cantidad_beneficiario).autoNumeric('update');;
                            $("#duracion_anios").val(hoja1.duracion_anios);
                            $("#duracion_meses").val(hoja1.duracion_meses);
                            for (var i = 0; i < fuentes.length; i++) {
                                if (fuentes[i].tipo_fuente == 'F') {
                                    if (i === 0) {
                                        $(".monfed:first").val(fuentes[i].monto).autoNumeric('update');
                                        $('select[name="fuente_federal[]"]:eq(0) option[value=' + fuentes[i].id_fuente + ']').prop('selected', 'selected');
                                    } else {
                                        addfed($(".monfed:first"), function() {
                                            $(".monfed:eq(" + i + ")").val(fuentes[i].monto).autoNumeric('update');
                                            $('select[name="fuente_federal[]"]:eq(' + i + ') option[value=' + fuentes[i].id_fuente + ']').prop('selected', 'selected');
                                        });
                                    }
                                } else {
                                    j = 0;
                                    if (j === 0) {
                                        $(".monest:first").val(fuentes[i].monto).autoNumeric('update');
                                        $('select[name="fuente_estatal[]"]:eq(0) option[value=' + fuentes[i].id_fuente + ']').prop('selected', 'selected');
                                    } else {
                                        addest($(".monest:first"), function() {
                                            $(".monest:eq(" + j + ")").val(fuentes[i].monto).autoNumeric('update');
                                            $('select[name="fuente_estatal[]"]:eq(' + j + ') option[value=' + fuentes[i].id_fuente + ']').prop('selected', 'selected');
                                        });
                                    }
                                    j++;
                                }
                            }
                            //     if (info.infoFteFed[i].idFte === "134" || info.infoFteFed[i].idFte === "136") {
                            //         $("#isFM").val("1");
                            //         $("#idDetFon").val(info.FM.IdDetFon);
                            //         $('select[name="ffed[]"]:eq(' + i + ') option[value=' + info.infoFteFed[i].idFte + ']').parent().parent().parent().popover({
                            //             html: true,
                            //             animation: true,
                            //             trigger: "focus",
                            //             content: "<p style='width: 150px;'>Proyecto seleccionado: <b>" + info.FM.CvePry + " - " + info.FM.NomPry + "</b></p><p>Monto disponible: <b>$<span class='numeroDecimal'>" + info.FM.disponiblePry + "</span></b></p><p><span class='btn btn-default' onclick='cambioProyectoFM(" + info.FM.idFte + ");'>Cambiar proyecto</span></p>",
                            //             placement: "top"
                            //         }).on('shown.bs.popover', function() {
                            //             $('.numeroDecimal').autoNumeric({
                            //                 mDec: 2
                            //             });
                            //         });
                            //     }
                            // }
                            $("#monto_fuente_municipal").val(hoja1.monto_municipal).autoNumeric('update');
                            $("#fuente_municipal").val(hoja1.fuente_municipal);
                            //check para las opciones de factibilidad Legal
                            var dataLeg = jQuery.parseJSON(hoja1.jfactibilidad_legal);
                            for (var i = 0; i < dataLeg.cu.length; i++) {
                                $.each(dataLeg.cu[i], function(key, value) {
                                    $("input[name=" + key + "][value='" + value + "']").prop("checked", true);
                                });
                            }
                            //check para las opciones de factibilidad Ambiental
                            //uso de suelo
                            var dataAmb = jQuery.parseJSON(hoja1.jfactibilidad_ambiental);
                            for (var i = 0; i < dataAmb.uso_suelo.length; i++) {
                                $.each(dataAmb.uso_suelo[i], function(key, value) {
                                    $("input[name=" + key + "][value='" + value + "']").prop("checked", true);
                                });
                            }
                            //impacto ambiental
                            for (var i = 0; i < dataAmb.impacto_ambiental.length; i++) {
                                $.each(dataAmb.impacto_ambiental[i], function(key, value) {
                                    $("input[name=" + key + "][value='" + value + "']").prop("checked", true);
                                });
                            }
                            //extensiones avisos
                            for (var i = 0; i < dataAmb.extensiones_avisos.length; i++) {
                                $.each(dataAmb.extensiones_avisos[i], function(key, value) {
                                    $("input[name=" + key + "][value='" + value + "']").prop("checked", true);
                                });
                            }
                            //check para las opciones de factibilidad Tecnica
                            var dataTec = jQuery.parseJSON(hoja1.jfactibilidad_tecnica);
                            for (var i = 0; i < dataTec.cu.length; i++) {
                                $.each(dataTec.cu[i], function(key, value) {
                                    $("input[name=" + key + "][value='" + value + "']").prop("checked", true);
                                });
                            }
                        }
                        // LLENADO DE DATOS DE LA HOJA 2
                        if (hoja2) {
                            $("#form_anexo_dos #id_hoja_dos").val(hoja2.id);
                            $("#form_anexo_dos #id_estudio_socioeconomico").val(data.id);
                            $("#form_anexo_dos #id_cobertura").val(hoja2.id_cobertura);
                            if (regiones.length > 0) {
                                $("#divRegiones").show(0, function() {
                                    arrRegiones = [];
                                    for (var i = 0; i < regiones.length; i++) {
                                        arrRegiones.push(regiones[i].id_region);
                                    }
                                    $("#id_region").select2({
                                        placeholder: "Seleccione la(s) región(es)"
                                    });
                                    $(".select2-container").css({
                                        width: '100%',
                                    });
                                    $("#id_region").val(arrRegiones).trigger('change');
                                })
                                $("#comloc").show();
                            }
                            if (municipios.length > 0) {
                                $("#divMunicipios").show(0, function() {
                                    arrMunicipios = [];
                                    for (var i = 0; i < municipios.length; i++) {
                                        arrMunicipios.push(municipios[i].id_municipio);
                                    }
                                    $("#id_municipio").select2({
                                        placeholder: "Seleccione la(s) región(es)"
                                    });
                                    $(".select2-container").css({
                                        width: '100%',
                                    });
                                    $("#id_municipio").val(arrMunicipios).trigger('change');
                                });
                                $("#comloc").show();
                            }
                            $("#form_anexo_dos #nombre_localidad").val(hoja2.nombre_localidad);
                            $("#form_anexo_dos #id_tipo_localidad").val(hoja2.id_tipo_localidad);
                            $("#form_anexo_dos #bcoordenadas").val(hoja2.bcoordenadas).change();
                            $("#form_anexo_dos #observaciones_coordenadas").val(hoja2.observaciones_coordenadas);
                            $("#form_anexo_dos #latitud_inicial").val(hoja2.latitud_inicial);
                            $("#form_anexo_dos #longitud_inicial").val(hoja2.longitud_inicial);
                            $("#form_anexo_dos #latitud_final").val(hoja2.latitud_final);
                            $("#form_anexo_dos #longitud_final").val(hoja2.longitud_final);
                            if (hoja2.microlocalizacion) {
                                $("#form_anexo_dos #vista_previa").attr('src', data.rutaReal + "/" + hoja2.microlocalizacion);
                            }
                        }
                    }
                } else {
                    $("#id_estudio_socioeconomico").notify("Error: " + data.error, "warn");
                }
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    } else {
        $("#id_estudio_socioeconomico").notify("Debe ingresar un número de Estudio Socioeconómico", "error");
    }
}

function guardar() {
    switch ($("#hojaActual").val()) {
        case '1':
            guardarHoja1();
            break;
        case '2':
            guardarHoja2();
            break;
    }
}

function enviar_dictaminar() {
    if ($("#id_estudio_socioeconomico").val() != "" && $("#id_hoja_uno").val() != "" && $("#id_hoja_dos").val() != "") {
        $("#id_estudio_socioeconomico").notify({
            title: '¿Deseas enviar a dictaminar?',
            button: 'Confirm'
        }, {
            style: 'foo',
            autoHide: false,
            clickToHide: false
        });
        return;
    }
}

function confirm_dictaminar() {
    $.ajax({
        data: {
            'id_estudio_socioeconomico': $("#id_estudio_socioeconomico").val()
        },
        url: '/EstudioSocioeconomico/enviar_dictaminar',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            var data = response;
            if (!data.error) {
                $.notify("El Estudio Socioeconómico se ha invido correctamente.", "success");
                imprime_ficha_tecnica($("#id_estudio_socioeconomico").val());
            } else {
                $("#id_estudio_socioeconomico").notify("Error: " + data.error, "warn");
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function imprime_ficha_tecnica(id_estudio_socioeconomico) {
    if (id_estudio_socioeconomico) {
        window.open('/EstudioSocioeconomico/ficha_tecnica/' + id_estudio_socioeconomico + '', '_blank');
    } else {
        $("#id_estudio_socioeconomico").notify("No se ha ingresado ningún Estudio Socioeconómico", "warn");
    }
}