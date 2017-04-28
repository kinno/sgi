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
    $("#panel3").on('click', function() {
        $("#hojaActual").val('3');
    });
    $("#panel4").on('click', function() {
        $("#hojaActual").val('4');
    });
    $("#panel5").on('click', function() {
        $("#hojaActual").val('5');
    });
    $("#panel6").on('click', function() {
        $("#hojaActual").val('6');
    });
    $("#buscar").on('click', function() {
        buscarExpediente();
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

function buscarExpediente(){
        if ($("#id_expediente_tecnico_search").val() != "") {
        $.ajax({
            data: {
                'id_expediente_tecnico': $("#id_expediente_tecnico_search").val()
            },
            url: '/ExpedienteTecnico/buscar_expediente',
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
                    if (data.expediente.id) {
                        if (hoja1) {
                             llenarHoja1(data.expediente.id,hoja1,acuerdos,fuentes,'expediente',data.id_estudio_socioeconomico);
                        }
                        // // LLENADO DE DATOS DE LA HOJA 2
                        if (hoja2) {
                            llenarHoja2(data.expediente.id,hoja2,regiones,municipios,data.rutaReal,'expediente');
                        }
                        //Buscar y crear la tabla de conceptos
                        initDataConceptos(data.expediente.id);
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
                    hoja2.id = "";
                    regiones = data.regiones;
                    municipios = data.municipios;
                    if (data.id) {
                        if (hoja1) {
                             llenarHoja1(data.id,hoja1,acuerdos,fuentes,'estudio');
                        }
                        // // LLENADO DE DATOS DE LA HOJA 2
                        if (hoja2) {
                            llenarHoja2(data.id,hoja2,regiones,municipios,data.rutaReal,'estudio');
                           
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

