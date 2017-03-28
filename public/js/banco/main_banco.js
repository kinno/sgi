var bndCarga = true;
var lastDateIng = "";
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#fecha_ingreso').datepicker({
        language: "es",
        weekStart: 1,
        format: "dd-mm-yyyy",
        autoclose: true
    }).on('changeDate', function(e) {
        if (!bndCarga || lastDateIng === "") {
            if ($('#fecha_ingreso').val() !== "") {
                ingresarEstFisico();
                bndCarga = false;
            } else {
                bndCarga = true;
                $('#fecha_ingreso').val(lastDateIng);
                $('#fecha_ingreso').datepicker("update");
                bndCarga = false;
            }
        }
    });
    $("#CmbTipEva").on('change', function() {
        cambiaTipoEvaluacion();
    });
    $("#buscar").on('click', function(event) {
        event.preventDefault();
        /* Act on the event */
        buscar_info_estudio_banco()
    });
    $("#limpiar").on('click', function() {
        location.reload();
    });
    $("#guardar").click(function() {
        if ($("#tIdBco")) {
            $("#ingresoFisico").prop("checked", false);
            $('#CmbTipFir option[value=1]').prop('selected', 'selected');
            guardarEvaluacion();
        } else {
            $("#id_estudio_socioeconomico").notify("Error: No se ha capturado el Estudio Socioeconómico", "warn");
        }
    });
    $("#enviar_observaciones").click(function() {
        // bootbox.confirm("Se devolver\u00e1 el Estudio Socioecon\u00f3mico con observaciones, \u00BFDesea Continuar?", function (response) {
        // if (response) {
        if (confirm("Se devolverá el Estudio Socioeconómico con observaciones, Desea Continuar?")) {
            $('#CmbTipFir option[value=2]').prop('selected', 'selected');
            $("#ingresoFisico").prop("checked", true);
            $("#tFecIng").val("");
            guardarEvaluacion();
        }
        // });
    });
    $("#dictaminar").click(function() {
        // bootbox.confirm("Se dictaminar\u00e1 el Estudio Socioecon\u00f3mico, \u00BFDesea Continuar?", function (response) {
        // if (response) {
        if (confirm("Se dictaminará el Estudio Socioeconómico, Desea Continuar?")) {
            $('#CmbTipFir option[value=3]').prop('selected', 'selected');
            $("#ingresoFisico").prop("checked", false);
            guardarEvaluacion();
        }
        // });
    });
    $("#evaluacion_pdf").click(function() {
        imprime_dictamen($("#id_estudio_socioeconomico").val());
    });
    $("#tfTasDes").autoNumeric({
        aSep: '',
        mDec: 2,
        vMin: '0.00',
        vMax: "100.00"
    });
    $("#tfVAN,#tfVACPta,#tfCAEPta,#tfVACAlt,#tfCAEAlt").autoNumeric({
        aSep: ',',
        mDec: 2,
        vMin: '0.00'
    });
    $("#tfTIR,#tfTRI").autoNumeric({
        aSep: '',
        mDec: 2,
        vMin: '0.00',
        vMax: '999.99'
    });
    $("#numerobanco").autoNumeric({
        aSep: '',
        mDec: 0
    });
    $("#tFecIng").hide();
});

function cambiaTipoEvaluacion(callback) {
    if ($("#CmbTipEva").val() == 0) {
        $("#TblSubInc").html('<tr><td colaspan="10"><center>No se ha seleccionado tipo de evaluaci\u00f3n</center></td></tr>');
    } else {
        $.ajax({
            data: {
                idTipEva: $("#CmbTipEva").val()
            },
            url: '/Banco/obtener_tipo_evaluacion',
            type: 'post',
            success: function(response) {
                //console.log(response);
                $("#TblSubInc").html(response);
                if ($("#CmbTipEva").val() == 3 || $("#CmbTipEva").val() == 4) {
                    $("#InfEco").attr('hidden', false);
                    $("#InfSoc").attr('hidden', 'hidden');
                } else {
                    if ($("#CmbTipEva").val() == 5 || $("#CmbTipEva").val() == 6) {
                        $("#InfEco").attr('hidden', 'hidden');
                        $("#InfSoc").attr('hidden', false);
                    } else {
                        if ($("#CmbTipEva").val() == 2) {
                            $("#InfSoc").attr('hidden', 'hidden');
                            $("#InfEco").attr('hidden', 'hidden');
                        } else {
                            $("#InfEco").attr('hidden', false);
                            $("#InfSoc").attr('hidden', false);
                        }
                    }
                }
                //nuevas condiciones
                var tipoEvaluacionTmp = $("#CmbTipEva").val();
                switch (tipoEvaluacionTmp) {
                    case "1": //ficha tecnica
                        if (parseFloat($("#tMonto").text().replace(/,/g, "")) >= 30000000 && parseFloat($("#tMonto").text().replace(/,/g, "")) <= 50000000) {
                            $("#row_36").show();
                            $("#row_37").show();
                            $("#row_38").show();
                            $("#row_39").show();
                            $("#row_40").show();
                            $("#row_41").show();
                            $("#row_42").show();
                            $("#InfEco").show();
                            $("#InfSoc").show();
                        } else {
                            $("#row_36").hide();
                            $("#row_37").hide();
                            $("#row_38").hide();
                            $("#row_39").hide();
                            $("#row_40").hide();
                            $("#row_41").hide();
                            $("#row_42").hide();
                            $("#InfEco").hide();
                            $("#InfSoc").hide();
                        }
                        $("#tfTasDes").val("");
                        $("#TasDes").hide();
                        //
                        $("#tfVAN").hide();
                        $("#tfVAN").val("");
                        $("#tfTIR").hide();
                        $("#tfTIR").val("");
                        $("#tfTRI").hide();
                        $("#tfTRI").val("");
                        $("#tfVACPta").hide();
                        $("#tfVACPta").val("");
                        $("#tfCAEPta").hide();
                        $("#tfCAEPta").val("");
                        $("#tfVACAlt").hide();
                        $("#tfVACAlt").val("");
                        $("#tfCAEAlt").hide();
                        $("#tfCAEAlt").val("");
                        break;
                    case "2": //estudio de preinvencion
                        $("#row_36").hide();
                        $("#row_37").hide();
                        $("#row_38").hide();
                        $("#row_39").hide();
                        $("#row_40").hide();
                        $("#row_41").hide();
                        $("#row_42").hide();
                        $("#tfTasDes").val("");
                        $("#TasDes").hide();
                        $("#InfEco").hide();
                        $("#InfSoc").hide();
                        break;
                    case "3": //cb simplificado
                        $("#row_36").show();
                        $("#row_37").show();
                        $("#row_38").show();
                        $("#row_39").hide();
                        $("#row_40").hide();
                        $("#row_41").hide();
                        $("#row_42").hide();
                        $("#tfTasDes").val("10");
                        $("#TasDes").show();
                        $("#tfVAN").show();
                        $("#tfTIR").show();
                        $("#tfTRI").show();
                        $("#InfEco").show();
                        $("#InfSoc").show();
                        break;
                    case "4": //cb prefactibilidad
                        $("#row_36").show();
                        $("#row_37").show();
                        $("#row_38").show();
                        $("#row_39").hide();
                        $("#row_40").hide();
                        $("#row_41").hide();
                        $("#row_42").hide();
                        $("#tfTasDes").val("10");
                        $("#TasDes").show();
                        $("#tfVAN").show();
                        $("#tfTIR").show();
                        $("#tfTRI").show();
                        $("#InfEco").show();
                        $("#InfSoc").show();
                        break;
                    case "5": //ce simplificado
                        $("#row_36").hide();
                        $("#row_37").hide();
                        $("#row_38").hide();
                        $("#row_39").show();
                        $("#row_40").show();
                        $("#row_41").show();
                        $("#row_42").show();
                        $("#tfTasDes").val("10");
                        $("#TasDes").show();
                        $("#tfVAN").hide();
                        $("#tfVAN").val("");
                        $("#tfTIR").hide();
                        $("#tfTIR").val("");
                        $("#tfTRI").hide();
                        $("#tfTRI").val("");
                        $("#tfVACPta").show();
                        $("#tfCAEPta").show();
                        $("#tfVACAlt").show();
                        $("#tfCAEAlt").show();
                        $("#InfEco").show();
                        $("#InfSoc").show();
                        break;
                    case "6": //ce prefactibilidad
                        $("#row_36").hide();
                        $("#row_37").hide();
                        $("#row_38").hide();
                        $("#row_39").show();
                        $("#row_40").show();
                        $("#row_41").show();
                        $("#row_42").show();
                        $("#tfTasDes").val("10");
                        $("#TasDes").show();
                        $("#tfVAN").hide();
                        $("#tfVAN").val("");
                        $("#tfTIR").hide();
                        $("#tfTIR").val("");
                        $("#tfTRI").hide();
                        $("#tfTRI").val("");
                        $("#tfVACPta").show();
                        $("#tfCAEPta").show();
                        $("#tfVACAlt").show();
                        $("#tfCAEAlt").show();
                        $("#InfEco").show();
                        $("#InfSoc").show();
                        break;
                }
                if (typeof(callback) === "function") {
                    callback();
                }
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    }
}

function buscar_info_estudio_banco() {
    $.ajax({
        data: {
            id_estudio_socioeconomico: $("#id_estudio_socioeconomico").val()
        },
        url: '/Banco/buscar_estudio',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            if (!response.error) {
                var data = response;
                console.log(data);
                
                $("#tIdBco").html(data.id);
                // $("#tIdSol").html(info.infoData[0].IdSol);
                // $("#taObsDgi").html(info.infoData[0].obs);
                $("#tMonto").html(data.hoja1.monto);
                $("#tMonto").autoNumeric();
                $("#tFecCap").html(data.fecha_registro);
                $("#tNomSol").html(data.hoja1.nombre_obra);
                $("#tSector").html(data.hoja1.id_sector);
                $("#tUE").html(data.hoja1.id_unidad_ejecutora);
                $("#tEjercicio").html(data.hoja1.ejercicio);
                $("#tPriCar").html(data.hoja1.principales_caracteristicas);
                $("#tDurAnio").html(data.hoja1.duracion_anios);
                $("#tDurMes").html(data.hoja1.duracion_meses);
                $("#tFteMun").html('<b>' + (data.hoja1.monto_municipal) ? data.hoja1.monto_municipal : 0.00 + '</b>').autoNumeric();
                $("#tFteMun").append('&nbsp;(' + (data.hoja1.fuente_municipal) ? data.hoja1.fuente_municipal : '' + ')');
                var fuentesFederales = "";
                var fuentesEstatales = "";
                for (var i = 0; i < data.fuentes_monto.length; i++) {
                    if (data.fuentes_monto[i].tipo_fuente == "F") {
                        fuentesFederales = fuentesFederales + "<span class='number' style='font-weight:bold;'>" + data.fuentes_monto[i].monto + "</span> (" + data.fuentes_monto[i].detalle_fuentes[0].descripcion + ")<br>";
                    } else {
                        fuentesEstatales = fuentesEstatales + "<span class='number' style='font-weight:bold;'>" + data.fuentes_monto[i].monto + "</span> (" + data.fuentes_monto[i].detalle_fuentes[0].descripcion + ")<br>";
                    }
                }
                if (fuentesFederales === "") {
                    $("#tFteFed").html("0.00 ()");
                } else {
                    $("#tFteFed").html(fuentesFederales);
                }
                if (fuentesEstatales === "") {
                    $("#tFteEst").html("0.00 ()");
                } else {
                    $("#tFteEst").html(fuentesEstatales);
                }
                $(".number").autoNumeric();
                $("#CmbTipFir option[value=1]").prop('selected', 'selected');
                $('#CmbTipEva option[value=' + data.id_tipo_evaluacion + ']').prop('selected', 'selected');
                cambiaTipoEvaluacion(function() {
                    //RECUPERAR INFORMACION DE INDICADORES DE RENTABILIDAD
                    if (data.indicadores.length > 0) {
                        for (var i = 0; i < data.indicadores.length; i++) {
                            if (i === 0) {
                                $('#CmbTipInf option[value=' + data.indicadores[i].id_tipo_ppi + ']').prop('selected', 'selected').change();
                                $("#tfTasDes").val(data.indicadores[i].tasa_social_descuento);
                                $("#tfVAN").val(data.indicadores[i].van);
                                $("#tfTIR").val(data.indicadores[i].tir);
                                $("#tfTRI").val(data.indicadores[i].tri);
                                $("#tfVACPta").val(data.indicadores[i].vacpta);
                                $("#tfCAEPta").val(data.indicadores[i].caepta);
                                $("#tfVACAlt").val(data.indicadores[i].vacalt);
                                $("#tfCAEAlt").val(data.indicadores[i].caealt);
                                $("#tfVAN,#tfVACPta,#tfCAEPta,#tfVACAlt,#tfCAEAlt").autoNumeric("update");
                                $("#taObsDgi").val(data.indicadores[i].observaciones);
                            }
                            // if (info.infoData[0].Status === "5" && i === 0) {
                            if (data.id_estatus === 4 && i === 0) {
                                $.each(data.indicadores[i].evaluaciones, function(index, value) {
                                    //console.log(value.IdSubInc + '--' + value.IdRsp + '--' + value.Observa);                                                                    
                                    idChild = $("#row_" + value.id_sub_indice).attr('class');
                                    $("#idResp" + value.brespuesta + "_" + idChild).attr('checked', 'checked');
                                    if (value.brespuesta == 2) {
                                        changeRadio(1, idChild);
                                        $("#taPag_" + idChild).val(value.pagina);
                                        $("#taObs_" + idChild).val(value.observaciones);
                                    }
                                });
                            } else {
                                if (data.indicadores[i].observaciones !== "" && data.indicadores[i].observaciones) agregarCarrucelObs($("#taObsDgiForCarr"), data.indicadores[i].observaciones, data.indicadores[i].fecha);
                                $.each(data.indicadores[i].evaluaciones, function(index, value) {
                                    //console.log(value.IdSubInc + '--' + value.IdRsp + '--' + value.Observa);                                                                    
                                    idChild = $("#row_" + value.id_sub_indice).attr('class');
                                    if (value.observaciones !== "" && value.observaciones) {
                                        agregarCarrucelObs($("#taObs_" + idChild).parent(), value.observaciones, data.indicadores[i].fecha);
                                    }
                                });
                                //aqui va la funcion que incluya el carrusel
                            }
                        }
                        if ($("#datosES:visible").length !== 0) {
                            $(".carrucel").find("ul").lightSlider({
                                loop: false,
                                keyPress: false,
                                item: 1,
                                pager: false,
                                onBeforeSlide: function(el) {
                                    $(this).parent().parent().parent().find(".pagerCarrucel").text(el.getCurrentSlideCount());
                                }
                            });
                        }
                    }
                });
                //si el estudio se encuantra en revision por la independencia se limita el uso del boton guardar
                if (data.movimientos.id_tipo_movimiento == 1 || data.movimientos.id_tipo_movimiento == 5 || data.movimientos.id_tipo_movimiento == 6) {
                    $("#guardar").hide();
                    $("#dictaminar").hide();
                    $("#enviar_observaciones").hide();
                } else {
                    $("#guardar").show();
                    $("#dictaminar").show();
                    $("#enviar_observaciones").show();
                }
                if (data.fecha_ingreso == "" || !data.fecha_ingreso) { //SI NO HAY FECHA DE INGRESO FISICO NO SE PUEDE REGRESAR NI DICTAMINAR
                    $("#enviar_observaciones,#dictaminar").hide();
                } else {
                    lastDateIng = data.fecha_ingreso;
                    $("#fecha_ingreso").val(data.fecha_ingreso);
                    $("#fecha_ingreso").datepicker("update");
                    bndCarga = false;
                    if (data.fecha_ingreso === 6) {
                        $("#fecha_ingreso").datepicker("remove");
                    }
                    $("#datosES").show();
                }
                if(data.id_estatus==6){ //DICTAMINADO
                    $.notify("El Estudio Socioeconómico ya ha sido dicaminado con el dictamen: "+data.dictamen, "success");
                        $("#evaluacion_pdf").show();
                        $("#guardar,#enviar_observaciones,#dictaminar").hide();
                }
            } else {
                $("#id_estudio_socioeconomico").notify(response.error, "error");
            }
        },
        error: function(response) {
            console.log("Errores::", response);
            $("#divLoading").hide();
        }
    });
}

function agregarCarrucelObs(elem, observacion, fecha) {
    if ($(elem).prev("div").attr("class") === "carrucel input-sm") {
        $(elem).prev("div").find(".totalCarrucel").text(parseInt($(elem).prev("div").find(".totalCarrucel").text()) + 1);
        addObsToCarrucel($(elem).prev("div"), observacion, fecha);
    } else {
        var estructura = $("<div class='carrucel input-sm' title='Historial de observaciones'><span class='pagerCarrucel'>1</span> de <span class='totalCarrucel'>1</span><ul></ul></div>");
        $(elem).before(estructura);
        addObsToCarrucel(estructura, observacion, fecha);
    }
}

function addObsToCarrucel(elem, observacion, fecha) {
    $(elem).find("ul").append("<li style='overflow-y: auto; height: 33px !important;'><span>" + fecha + " - " + observacion + "</span></li>");
}

function guardarEvaluacion(callback) {
    var error = 0;
    if ($("#tIdBco").html() == '') {
        $("#id_estudio_socioeconomico").notify("Ingrese un Estudio Socioeconómico", "warn");
        error = 1;
        return false;
    }
    if ($("#CmbTipEva").val() !== "0") {
        $(".radio_send").each(function(index) {
            var element = $(this).attr('id').split("_");
            var idElement = element[1];
            if ($("input[name='idResp_" + idElement + "']:checked").val() === "2") {
                if ($("#taObs_" + idElement).val().length < 1) {
                    bootbox.alert('Ingresa las observaciones para la opci\u00F3n seleccionada');
                    error = 1;
                    $("#taObs_" + idElement).focus();
                    return false;
                }
            }
        });
    }
    if ($("#CmbTipEva").val() === "0" && ($('#ingresoFisico').prop('checked') === false)) {
        bootbox.alert('Selecciona un tipo de evaluaci\u00F3n');
        error = 1;
        return false;
    }
    if ($("#CmbTipFir").val() === "3") {
        $(".radio_send").each(function(index) {
            var element = $(this).attr('id').split("_");
            var idElement = element[1];
            if ($("input[name='idResp_" + idElement + "']:checked").val() == 2) {
                if ($("#taObs_" + idElement).val().length > 1) {
                    bootbox.alert('Para poder dictaminar, no se deben tener observaciones');
                    error = 1;
                    $("#taObs_" + idElement).focus();
                    return false;
                }
            }
        });
    }
    if (error == 0) {
        var infoObservaciones = new Array();
        $(".text_send").each(function(index) {
            var element = $(this).attr('id').split("_");
            var idElement = element[1];
            //console.log( element + ": " + idElement );                        
            infoObservaciones.push({
                'id_sub_indice': $("#subInc_" + idElement).val(),
                'brespuesta': $("input[name='idResp_" + idElement + "']:checked").val(),
                'pagina': $("#taPag_" + idElement).val(),
                'observacion': $("#taObs_" + idElement).val()
            });
        });
        datos = {
            'id_estudio_socioeconomico': $("#tIdBco").html(),
            'IdTipInf': $('#CmbTipInf').val(),
            'tasa_social_descuento': $("#tfTasDes").val(),
            'van': $("#tfVAN").val().replace(/,/g, ""),
            'tir': $("#tfTIR").val().replace(/,/g, ""),
            'tri': $("#tfTRI").val().replace(/,/g, ""),
            'vacpta': $("#tfVACPta").val().replace(/,/g, ""),
            'caepta': $("#tfCAEPta").val().replace(/,/g, ""),
            'vacalt': $("#tfVACAlt").val().replace(/,/g, ""),
            'caealt': $("#tfCAEAlt").val().replace(/,/g, "")
        };
        var ingreso = "";
        if ($('#ingresoFisico').prop('checked')) {
            ingreso = $("#fecha_ingreso").val();
        } else {
            ingreso = false;
        }
        generales = {
            'id_estudio_socioeconomico': $("#tIdBco").html(),
            'id_evaluacion': $('#CmbTipEva').val(),
            'observaciones': $("#taObsDgi").val(),
            'IngresoFisico': ingreso,
            'AccionSeguir': $("#CmbTipFir").val()
        };
        $.ajax({
            data: {
                datos: datos,
                observaciones: infoObservaciones,
                generales: generales
            },
            url: '/Banco/guardar_evaluacion',
            type: 'post',
            beforeSend: function() {
                $("#divLoading").show();
            },
            complete: function() {
                $("#divLoading").hide();
            },
            success: function(response) {
                if (!response.error) {
                    if (!response.dictamen) {
                        $.notify("Datos guardados", "success");
                    } else {
                        $.notify("Se generó el dictamen: " + response.dictamen, "success");
                        $("#btnEvaluacionPdf").css('display', 'block');
                        $("#guardar,#enviar_observaciones,#dictaminar").hide();
                        imprime_dictamen(response.id_estudio_socioeconomico);
                    }
                } else {
                    $.notify("Error: Ocurrió un error al guardar", "error");
                }
                // var info = jQuery.parseJSON(response);
                // console.log(info);
                // //1.:si es el ingreso fisico aqui se debe enviar la notificacion
                // if (info.ingresoFisico) {
                //     $("#btnEvaluacionPdf").css('display', 'none');
                //     sendNotification("", $("#idUsuarioSession").val(), "", "", $("#idRolUsuarioSession").val(), generales.IdBco, "4", "", $("#tMonto").text().replace(/,/g, "")); // notificacion                            
                //     bootbox.alert('Se ingres\u00f3  estudio f\u00edsico');
                //     $("#enviar_observaciones,#dictaminar").show();
                // }
                // //2.:si es el DICTAMEN aqui se debe enviar la notificacion
                // if ((info.dictamen)) {
                //     $("#btnEvaluacionPdf").css('display', 'block');
                //     $("#enviar_observaciones,#btnIngFisico,#dictaminar,#guardar").hide();
                //     sendNotification("", $("#idUsuarioSession").val(), "", "", $("#idRolUsuarioSession").val(), generales.IdBco, "6", info.dictamen, ""); // notificacion
                //     bootbox.alert('Se guardo el dictamen con id: ' + info.dictamen, function() {
                //         location.reload();
                //     });
                // }
                // //3.:si Hay observaciones aqui se debe enviar la notificacion
                // if (info.observaciones) {
                //     if (info.AccionSeguir !== "1") {
                //         $("#valEva").html(info.idEva);
                //         sendNotification("", $("#idUsuarioSession").val(), "", "", $("#idRolUsuarioSession").val(), generales.IdBco, "2", "", $("#tMonto").text().replace(/,/g, "")); // notificacion
                //         bootbox.alert('Se envi\u00f3 con observaciones.', function() {
                //             location.reload();
                //         });
                //         $("#enviar_observaciones,#btnIngFisico,#dictaminar,#guardar").hide();
                //     } else {
                //         bootbox.alert('Cambios guardados correctamente', function() {
                //             location.reload();
                //         });
                //     }
                // }
                if (typeof(callback) === "function") {
                    callback();
                    $("#divLoading").hide();
                } else {
                    $("#divLoading").hide();
                }
            },
            error: function(response) {
                console.log("Errores::", response);
                $("#divLoading").hide();
            }
        });
    }
}

function changeRadio(valor, idElement) {
    if (valor == 1) {
        $("#taObs_" + idElement).val('');
        $("#taObs_" + idElement).attr('readonly', false);
        $("#taPag_" + idElement).val('');
        $("#taPag_" + idElement).attr('readonly', false);
    } else if (valor == 0) {
        $("#taObs_" + idElement).val('');
        $("#taObs_" + idElement).attr('readonly', true);
        $("#taPag_" + idElement).val('');
        $("#taPag_" + idElement).attr('readonly', true);
    }
    var valorRadio = $("input[name='idResp_" + idElement + "']:checked").val();
    switch (idElement) {
        case 35:
            switch (valorRadio) {
                case "1":
                case "2":
                    $("#tfVAN").show();
                    break;
                case "3":
                    $("#tfVAN").hide();
                    $("#tfVAN").val("");
                    break;
            }
            break;
        case 36:
            switch (valorRadio) {
                case "1":
                case "2":
                    $("#tfTIR").show();
                    break;
                case "3":
                    $("#tfTIR").hide();
                    $("#tfTIR").val("");
                    break;
            }
            break;
        case 37:
            switch (valorRadio) {
                case "1":
                case "2":
                    $("#tfTRI").show();
                    break;
                case "3":
                    $("#tfTRI").hide();
                    $("#tfTRI").val("");
                    break;
            }
            break;
        case 38:
            switch (valorRadio) {
                case "1":
                case "2":
                    $("#tfVACPta").show();
                    break;
                case "3":
                    $("#tfVACPta").hide();
                    $("#tfVACPta").val("");
                    break;
            }
            break;
        case 39:
            switch (valorRadio) {
                case "1":
                case "2":
                    $("#tfCAEPta").show();
                    break;
                case "3":
                    $("#tfCAEPta").hide();
                    $("#tfCAEPta").val("");
                    break;
            }
            break;
        case 40:
            switch (valorRadio) {
                case "1":
                case "2":
                    $("#tfVACAlt").show();
                    break;
                case "3":
                    $("#tfVACAlt").hide();
                    $("#tfVACAlt").val("");
                    break;
            }
            break;
        case 41:
            switch (valorRadio) {
                case "1":
                case "2":
                    $("#tfCAEAlt").show();
                    break;
                case "3":
                    $("#tfCAEAlt").hide();
                    $("#tfCAEAlt").val("");
                    break;
            }
            break;
    }
}

function ingresarEstFisico() {
    // bootbox.confirm("Se ingresar\u00e1 el Estudio Socioecon\u00f3mico f\u00edsicamente y se notificar\u00e1 a la Unidad Ejecutora. \u00BFDesea Continuar?", function(response) {
    //     if (response) {
    if (confirm("Se ingreserá el Estudio Socioecómico físicamente y se notificará a la Unidad Ejecutora. Desea Continuar?")) {
        $('#CmbTipFir option[value=0]').prop('selected', 'selected');
        $("#ingresoFisico").prop("checked", true);
        guardarEvaluacion(function() {
            $("#ingresoFisico").prop("checked", false);
            $("#datosES").show("fast", function() {
                if ($(".lSSlideWrapper").length === 0) {
                    $(".carrucel").find("ul").lightSlider({
                        loop: false,
                        keyPress: false,
                        item: 1,
                        pager: false,
                        onBeforeSlide: function(el) {
                            $(this).parent().parent().parent().find(".pagerCarrucel").text(el.getCurrentSlideCount());
                        }
                    });
                }
            });
        });
        lastDateIng = $("#fecha_ingreso").val();
    } else {
        bndCarga = true;
        $("#fecha_ingreso").val(lastDateIng);
        $("#fecha_ingreso").datepicker("update");
        bndCarga = false;
    }
    // }
    // // );
}

function imprime_dictamen(id_estudio_socioeconomico) {
    if (id_estudio_socioeconomico) {
        window.open('/Banco/imprime_dictamen/' + id_estudio_socioeconomico + '', '_blank');
    } else {
        $("#id_estudio_socioeconomico").notify("No se ha ingresado ningún Estudio Socioeconómico", "warn");
    }
}