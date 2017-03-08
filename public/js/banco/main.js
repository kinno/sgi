$(document).ready(function () {
    $.ajaxSetup(
    {
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    
    $("#CmbTipEva").on('change',function(){

      cambiaTipoEvaluacion($(this).val());
  });

});


function cambiaTipoEvaluacion(val){
	if ($("#CmbTipEva").val() == 0) {
        $("#TblSubInc").html('<tr><td colaspan="10"><center>No se ha seleccionado tipo de evaluaci\u00f3n</center></td></tr>');
    } else {
        $.ajax({
            data: {
                idTipEva: val
            },
            url: '/Banco/obtener_tipo_evaluacion',
            type: 'post',
            success: function (response) {
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
                    case "1"://ficha tecnica
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
                    case "2"://estudio de preinvencion
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
                    case "3"://cb simplificado
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
                    case "4"://cb prefactibilidad
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
                    case "5"://ce simplificado
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
                    case "6"://ce prefactibilidad
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
                // if (typeof (callback) === "function") {
                //     callback();
                // }

            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
}

function obtenerInfoBco() {    
    $.ajax({
        data: {
            accion: 'obtenerInfoBcoSol',
            idBco: $("#numerobanco").val()
        },
        url: 'contenido_SGI/controller/banco/bancoController.php',
        type: 'post',
        beforeSend: function () {
            colocaWaitGeneral();
        },
        success: function (response) {
            var info = jQuery.parseJSON(response);
            console.log(info);
            if (info.infoRes) {
                if (info.infoData[0].Status !== "3" && info.infoData[0].Status !== "6" && info.infoData[0].Status !== "5" && info.infoData[0].Status !== "4") {
                    bootbox.alert('Solicitud no enviada para dictamen');
                    eliminaWaitGeneral();
                    return false;
                } else if ((info.infoRes)) {
                    if (info.infoData[0].Status === "6") {
                        bootbox.alert('Solicitud dictaminada');                        
                        $("#btnEvaluacionPdf").show();
                    }
                    else {
                        $("#btnEvaluacionPdf").hide();
                    }


                    $("#tIdBco").html(info.infoData[0].IdBco);
                    $("#tIdSol").html(info.infoData[0].IdSol);
                    $("#taObsDgi").html(info.infoData[0].obs);
                    $("#tMonto").html(info.infoData[0].Monto);
                    $("#tMonto").autoNumeric();
                    $("#tFecCap").html(info.infoData[0].FecRegistro);
                    $("#tNomSol").html(info.infoData[0].NomObr);
                    $("#tSector").html(info.infoData[0].NomSec);
                    $("#tUE").html(info.infoData[0].NomUE);
                    $("#tEjercicio").html(info.infoData[0].Ejercicio);
                    $("#tPriCar").html(info.infoData[0].PriCar);
                    $("#tDurAnio").html(info.infoData[0].DurAgs);
                    $("#tDurMes").html(info.infoData[0].DurMes);
                    $("#tFteMun").html('<b>' + info.infoData[0].MonMun + '</b>').autoNumeric();
                    $("#tFteMun").append('&nbsp;(' + info.infoData[0].FteMun + ')');
                    $("#CmbTipFir option[value=1]").prop('selected', 'selected');
                    $('#CmbTipEva option[value=' + info.infoData[0].IdTipEva + ']').prop('selected', 'selected');
                    cambioTipoEva(function () {
                        //RECUPERAR INFORMACION DE INDICADORES DE RENTABILIDAD
                        if (info.infoEstSol) {
                            for (var i = 0; i < info.infoEstSol.length; i++) {
                                if (i === 0) {
                                    $('#CmbTipInf option[value=' + info.infoEstSol[i].IdTipInf + ']').prop('selected', 'selected').change();
                                    $("#tfTasDes").val(info.infoEstSol[i].TasDes);
                                    $("#tfVAN").val(info.infoEstSol[i].VAN);
                                    $("#tfTIR").val(info.infoEstSol[i].TIR);
                                    $("#tfTRI").val(info.infoEstSol[i].TRI);
                                    $("#tfVACPta").val(info.infoEstSol[i].VACPta);
                                    $("#tfCAEPta").val(info.infoEstSol[i].CAEPta);
                                    $("#tfVACAlt").val(info.infoEstSol[i].VACAlt);
                                    $("#tfCAEAlt").val(info.infoEstSol[i].CAEAlt);
                                    $("#tfVAN,#tfVACPta,#tfCAEPta,#tfVACAlt,#tfCAEAlt").autoNumeric("update");
                                    $("#taObsDgi").val(info.infoEstSol[i].obs);
                                }
                                if (info.infoData[0].Status === "5" && i === 0) {
                                    $.each(info.infoEstSol[i].infoDetEva, function (index, value) {
                                        //console.log(value.IdSubInc + '--' + value.IdRsp + '--' + value.Observa);                                                                    
                                        idChild = $("#row_" + value.IdSubInc).attr('class');
                                        $("#idResp" + value.IdRsp + "_" + idChild).attr('checked', 'checked');
                                        if (value.IdRsp == 2) {
                                            changeRadio(1, idChild);
                                            $("#taPag_" + idChild).val(value.Pagina);
                                            $("#taObs_" + idChild).val(value.Observa);
                                        }
                                    });
                                } else {
                                    agregarCarrucelObs($("#taObsDgiForCarr"), info.infoEstSol[i].obs, info.infoEstSol[i].FecAce);
                                    $.each(info.infoEstSol[i].infoDetEva, function (index, value) {
                                        //console.log(value.IdSubInc + '--' + value.IdRsp + '--' + value.Observa);                                                                    
                                        idChild = $("#row_" + value.IdSubInc).attr('class');
                                        if (value.Observa !== "") {
                                            agregarCarrucelObs($("#taObs_" + idChild).parent(), value.Observa, info.infoEstSol[i].FecAce);
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
                                    onBeforeSlide: function (el) {
                                        $(this).parent().parent().parent().find(".pagerCarrucel").text(el.getCurrentSlideCount());
                                    }
                                });
                            }
                        }
                    });

                    if (info.infoFteFed === "") {
                        $("#tFteFed").html("0.00 ()");
                    } else {
                        $("#tFteFed").html(info.infoFteFed);
                    }

                    if (info.infoFteEst === "") {
                        $("#tFteEst").html("0.00 ()");
                    } else {
                        $("#tFteEst").html(info.infoFteEst);
                    }

                    //si el estudio se encuantra en revision por la independencia se limita el uso del boton guardar
                    if (info.tipMov == 2 || info.tipMov == 6) {
                        $("#btnGuardarEvaluacion").hide();
                        $("#btnDictaminar").hide();
                        $("#btnEnviarObs").hide();

                    }
                    else {
                        $("#btnGuardarEvaluacion").show();
                        $("#btnDictaminar").show();
                        $("#btnEnviarObs").show();
                    }
                    if (info.infoData[0].FecIngEstudio == "") { //SI NO HAY FECHA DE INGRESO FISICO NO SE PUEDE REGRESAR NI DICTAMINAR
                        $("#btnEnviarObs,#btnDictaminar").hide();
                    } else {
                        lastDateIng = info.infoData[0].FecIngEstudio;
                        $("#tFecIng").val(info.infoData[0].FecIngEstudio);
                        $("#tFecIng").datepicker("update");
                        bndCarga = false;
                        if (info.infoData[0].Status === "6") {
                            $("#tFecIng").datepicker("remove");
                        }
                        $("#datosES").show();
                    }

                } else {
                    bootbox.alert('Solicitud inexistente');
                    eliminaWaitGeneral();
                    return false;
                }
            } else {
                bootbox.alert('Solicitud inexistente');
                eliminaWaitGeneral();
                return false;
            }
            $("#tFecIng").show();
            eliminaWaitGeneral();           
        },
        error: function (response) {
            console.log("Errores::", response);
            eliminaWaitGeneral();
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
    if ($("#tIdSol").html() == '') {
        bootbox.alert('Ingresa un No. de Banco de proyecto a evaluar');
        error = 1;
        return false;
    }

    if ($("#CmbTipEva").val() !== "0") {

        $(".radio_send").each(function (index) {

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
        $(".radio_send").each(function (index) {
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

        $(".text_send").each(function (index) {
            var element = $(this).attr('id').split("_");
            var idElement = element[1];
            //console.log( element + ": " + idElement );                        
            infoObservaciones.push({
                'IdSubInc': $("#subInc_" + idElement).val(),
                'IdRsp': $("input[name='idResp_" + idElement + "']:checked").val(),
                'Pagina': $("#taPag_" + idElement).val(),
                'Observa': $("#taObs_" + idElement).val()
            });
        });

        datos = {
            'IdSol': $("#tIdSol").html(),
            'IdTipInf': $('#CmbTipInf').val(),
            'TasDes': $("#tfTasDes").val(),
            'VAN': $("#tfVAN").val().replace(/,/g, ""),
            'TIR': $("#tfTIR").val().replace(/,/g, ""),
            'TRI': $("#tfTRI").val().replace(/,/g, ""),
            'VACPta': $("#tfVACPta").val().replace(/,/g, ""),
            'CAEPta': $("#tfCAEPta").val().replace(/,/g, ""),
            'VACAlt': $("#tfVACAlt").val().replace(/,/g, ""),
            'CAEAlt': $("#tfCAEAlt").val().replace(/,/g, "")
        };
        var ingreso = "";
        if ($('#ingresoFisico').prop('checked')) {
            ingreso = $("#tFecIng").val();
        } else {
            ingreso = false;
        }
        generales = {
            'IdSol': $("#tIdSol").html(),
            'IdBco': $("#tIdBco").html(),
            'IdTipEva': $('#CmbTipEva').val(),
            'Observaciones': $("#taObsDgi").val(),
            'IngresoFisico': ingreso,
            'AccionSeguir': $("#CmbTipFir").val()
        };

        $.ajax({
            data: {
                accion: 'guardarEvaluacion',
                datos: datos,
                observaciones: infoObservaciones,
                generales: generales
            },
            url: 'contenido_SGI/controller/banco/bancoController.php',
            type: 'post',
            beforeSend: function () {
                colocaWaitGeneral();
            },
            success: function (response) {
                console.log(response);
                var info = jQuery.parseJSON(response);
                console.log(info);

                //1.:si es el ingreso fisico aqui se debe enviar la notificacion
                if (info.ingresoFisico) {
                    $("#btnEvaluacionPdf").css('display', 'none');
                    sendNotification("", $("#idUsuarioSession").val(),
                            "", "", $("#idRolUsuarioSession").val(), generales.IdBco, "4", "",$("#tMonto").text().replace(/,/g, ""));// notificacion                            
                    bootbox.alert('Se ingres\u00f3  estudio f\u00edsico');
                    $("#btnEnviarObs,#btnDictaminar").show();
                }

                //2.:si es el DICTAMEN aqui se debe enviar la notificacion
                if ((info.dictamen)) {
                    $("#btnEvaluacionPdf").css('display', 'block');
                    $("#btnEnviarObs,#btnIngFisico,#btnDictaminar,#btnGuardarEvaluacion").hide();
                    sendNotification("", $("#idUsuarioSession").val(),
                            "", "", $("#idRolUsuarioSession").val(), generales.IdBco, "6", info.dictamen,"");// notificacion
                    bootbox.alert('Se guardo el dictamen con id: ' + info.dictamen,function(){
                        location.reload();
                    });
                }

                //3.:si Hay observaciones aqui se debe enviar la notificacion
                if (info.observaciones) {
                    if (info.AccionSeguir !== "1") {
                        $("#valEva").html(info.idEva);
                        sendNotification("", $("#idUsuarioSession").val(),
                                "", "", $("#idRolUsuarioSession").val(), generales.IdBco, "2", "",$("#tMonto").text().replace(/,/g, ""));// notificacion
                        bootbox.alert('Se envi\u00f3 con observaciones.', function () {
                            location.reload();
                        });
                        $("#btnEnviarObs,#btnIngFisico,#btnDictaminar,#btnGuardarEvaluacion").hide();
                    } else {
                        bootbox.alert('Cambios guardados correctamente', function () {
                            location.reload();
                        });
                    }
                }
                if (typeof (callback) === "function") {
                    callback();
                    eliminaWaitGeneral();
                } else {
                    eliminaWaitGeneral();
                }
            },
            error: function (response) {
                console.log("Errores::", response);
                eliminaWaitGeneral();
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
    }
    else if (valor == 0) {
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
    bootbox.confirm("Se ingresar\u00e1 el Estudio Socioecon\u00f3mico f\u00edsicamente y se notificar\u00e1 a la Unidad Ejecutora. \u00BFDesea Continuar?", function (response) {
        if (response) {
            $('#CmbTipFir option[value=0]').prop('selected', 'selected');
            $("#ingresoFisico").prop("checked", true);
            guardarEvaluacion(function () {
                $("#ingresoFisico").prop("checked", false);
                $("#datosES").show("fast", function () {
                    if ($(".lSSlideWrapper").length === 0) {
                        $(".carrucel").find("ul").lightSlider({
                            loop: false,
                            keyPress: false,
                            item: 1,
                            pager: false,
                            onBeforeSlide: function (el) {
                                $(this).parent().parent().parent().find(".pagerCarrucel").text(el.getCurrentSlideCount());
                            }
                        });
                    }
                });
            });
            lastDateIng = $("#tFecIng").val();
        } else {
            bndCarga = true;
            $("#tFecIng").val(lastDateIng);
            $("#tFecIng").datepicker("update");
            bndCarga = false;
        }
    });

}