var error = false;
var tablaObservaciones;
jQuery(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#buscar").on('click', function() {
        buscarExpediente();
    });
    $("#limpiar").on('click', function() {
        location.reload();
    });
    // $("#observaciones").hide();
    $("#observaciones").on('click', function() {
        abrirObservaciones();
    });
    $("#guardar").on('click', function() {
        guardar();
    });
    $("#enviar_revision").on('click', function() {
        enviar_revision();
    });
    $("#panel1").on('click', function() {
        // if ($(this).hasClass('error')) {
        //     $.notify("Existen errores en el anexo actual, se deben corregir para cambiar de anexo", "error");
        //     return false;
        // }else{
        //     $("#hojaActual").val('1');    
        // }
        $("#hojaActual").val('1');
    });
    $("#panel2").on('click', function() {
        //  if ($(this).hasClass('error')) {
        //      $.notify("Existen errores en el anexo actual, se deben corregir para cambiar de anexo", "error");
        //     return false;
        // }else{
        //     $("#hojaActual").val('2');    
        // }
        $("#hojaActual").val('2');
    });
    $("#panel3").on('click', function() {
        // if ($(this).hasClass('error')) {
        //      $.notify("Existen errores en el anexo actual, se deben corregir para cambiar de anexo", "error");
        //     return false;
        // }else{
        //     $("#hojaActual").val('3');    
        // }
        $("#hojaActual").val('3');
    });
    $("#panel4").on('click', function() {
        // if ($(this).hasClass('error')) {
        //      $.notify("Existen errores en el anexo actual, se deben corregir para cambiar de anexo", "error");
        //     return false;
        // }else{
        //     $("#hojaActual").val('4');    
        // }
        $("#hojaActual").val('4');
    });
    $("#panel5").on('click', function() {
        //  if ($(this).hasClass('error')) {
        //      $.notify("Existen errores en el anexo actual, se deben corregir para cambiar de anexo", "error");
        //     return false;
        // }else{
        //     $("#hojaActual").val('5');    
        // }
        $("#hojaActual").val('5');
    });
    $("#panel6").on('click', function() {
        //  if ($(this).hasClass('error')) {
        //      $.notify("Existen errores en el anexo actual, se deben corregir para cambiar de anexo", "error");
        // }else{
        //     $("#hojaActual").val('6');    
        // }
        $("#hojaActual").val('6');
    });
    $("#imprimir_expediente").on('click', function() {
        imprime_expediente($("#form_anexo_uno #id_expediente_tecnico").val());
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
    $("#id_obra").on('change', function() {
        buscarObra();
    });
    tablaObservaciones = $('#tablaObservaciones').DataTable({
        "ordering": false,
        "searching": false,
        "destroy": false,
        columns: [{
            name: 'observaciones',
        }, {
            name: 'fecha',
        }]
    });
});

function guardar() {
    switch ($("#hojaActual").val()) {
        case '1':
            guardarHoja1();
            break;
        case '2':
            guardarHoja2();
            break;
        case '3':
            guardarHoja3();
            break;
        case '4':
            guardarHoja4();
            break;
        case '5':
            guardarHoja5();
            break;
        case '6':
            guardarHoja6();
            break;
    }
}

function buscarExpediente() {
    if ($("#id_expediente_tecnico_search").val() != "") {
        $.ajax({
            data: {
                'id_expediente_tecnico': $("#id_expediente_tecnico_search").val()
            },
            url: '/ExpedienteTecnico/Asignacion/buscar_expediente',
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
                    hoja1 = data.expediente.hoja1;
                    acuerdos = data.expediente.acuerdos;
                    fuentes = data.expediente.fuentes_monto;
                    hoja2 = data.expediente.hoja2;
                    regiones = data.expediente.regiones;
                    municipios = data.expediente.municipios;
                    avance_financiero = data.expediente.avance_financiero;
                    hoja5 = data.expediente.hoja5;
                    hoja6 = data.expediente.hoja6;
                    if (data.expediente.id) {
                        if (hoja1) {
                            llenarHoja1(data.expediente.id, hoja1, acuerdos, fuentes, 'expediente', data.id_estudio_socioeconomico);
                        }
                        // // LLENADO DE DATOS DE LA HOJA 2
                        if (hoja2) {
                            llenarHoja2(data.expediente.id, hoja2, regiones, municipios, data.rutaReal, 'expediente');
                        }
                        //Buscar y crear la tabla de conceptos
                        initDataConceptos(data.expediente.id);
                        initDataPrograma(data.expediente.id);
                        if (avance_financiero) {
                            llenarAvanceFinanciero(avance_financiero);
                        }
                        if (hoja5) {
                            llenarHoja5(data.expediente.id, hoja5);
                        }
                        if (hoja6) {
                            llenarHoja6(data.expediente.id, hoja6);
                        }
                        if (data.expediente.observaciones) {
                            $.each(data.expediente.observaciones, function(index, item) {
                                tablaObservaciones.row.add([item.observaciones, item.fecha_observacion]).draw();
                            })
                            $("#observaciones").show();
                        }
                    }
                } else {
                    $("#id_expediente_tecnico_search").notify("Error: " + data.error, "warn");
                }
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    } else {
        $("#id_expediente_tecnico_search").notify("Debe ingresar un número de Expediente Técnico", "error");
    }
}

function buscarBanco() {
    $.ajax({
        data: {
            'id_estudio_socioeconomico': $("#id_estudio_socioeconomico").val(),
            'externo': true
        },
        url: '/EstudioSocioeconomico/Asignacion/buscar_estudio',
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
                hoja2.id = "";
                regiones = data.regiones;
                municipios = data.municipios;
                if (data.id) {
                    if (hoja1) {
                        llenarHoja1(data.id, hoja1, acuerdos, fuentes, 'estudio');
                    }
                    // // LLENADO DE DATOS DE LA HOJA 2
                    if (hoja2) {
                        llenarHoja2(data.id, hoja2, regiones, municipios, data.rutaReal, 'estudio');
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
}

function buscarObra() {
    BootstrapDialog.confirm('¡Atención!', '¿Quieres crear el Expediente Técnico a partir del <b>número de Obra</b>?<br>No. Obra: ' + $("#id_obra").val() + ', Ejercicio: ' + $("#ejercicio").val(), function(result) {
        if (result) {
            $.ajax({
                data: {
                    'id_obra': $("#id_obra").val(),
                    'ejercicio': $("#ejercicio").val()
                },
                url: '/ExpedienteTecnico/Asignacion/buscar_obra',
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
                        hoja1 = data;
                        acuerdos = data.acuerdos;
                        fuentes = data.fuentes;
                        hoja2 = data;
                        regiones = data.regiones;
                        municipios = data.municipios;
                        if (!data.relacion.id_expediente_tecnico) {
                            if (hoja1) {
                                llenarHoja1(null, hoja1, acuerdos, fuentes, 'obra');
                            }
                            // // LLENADO DE DATOS DE LA HOJA 2
                            if (hoja2) {
                                llenarHoja2(null, hoja2, regiones, municipios, null, 'obra');
                            }
                        } else {
                            BootstrapDialog.mensaje(null, "La Obra seleccionada ya tiene registrado un Expediente Técnico", 3, function() {
                                $("#id_obra").val("");
                            });
                        }
                    } else {
                        BootstrapDialog.mensaje("Error.", data.error, 3, function() {
                                $("#id_obra").val("");
                            });
                    }
                },
                error: function(response) {
                    console.log("Errores::", response);
                }
            });
        } else {
            $("#id_obra").val('');
        }
    });
}

function enviar_revision() {
    BootstrapDialog.confirm('¡Atención!', '<b>¿Deseas enviar el Expediente Técnico a revisión a la DGI?</b><br> Una vez enviado ya no se podrán realizar cambios.', function(result) {
        if (result) {
            $.ajax({
                data: {
                    'id_expediente_tecnico': $("#form_anexo_uno #id_expediente_tecnico").val(),
                    'estatus': 2
                },
                url: '/ExpedienteTecnico/Asignacion/enviar_revision',
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
                        BootstrapDialog.mensaje(null, "El Expediente Técnico con folio: " + data.id_expediente_tecnico + " ha sido enviado a Revisión", 1, function() {
                            location.reload();
                        });
                    } else {
                        BootstrapDialog.mensaje(null, data.error, 3);
                    }
                },
                error: function(response) {
                    console.log("Errores::", response);
                }
            });
        }
    });
}

function imprime_expediente(id_expediente_tecnico) {
    if (id_expediente_tecnico) {
        window.open('/ExpedienteTecnico/impresion_expediente/' + id_expediente_tecnico + '', '_blank');
    } else {
        $("#id_estudio_socioeconomico").notify("No se ha ingresado ningún Estudio Socioeconómico", "warn");
    }
}

function colocaNotificacion(elem, aviso, clase, posicion) {
    if (!elem) {
        $.notify(aviso, {
            autoHide: false,
            clickToHide: false,
            className: clase,
            position: posicion
        });
    } else {
        $(elem).notify(aviso, {
            autoHide: false,
            clickToHide: false,
            className: clase,
            position: posicion
        });
    }
}

function eliminaNotificacion() {
    $('.notifyjs-wrapper').trigger('notify-hide');
}

function desactivaNavegacion(errornav) {
    if (errornav) {
        $("ul.nav-tabs>li").addClass('error');
    } else {
        $("ul.nav-tabs>li").removeClass('error');
    }
}

function abrirObservaciones() {
    $("#modal_observaciones").modal("show");
}