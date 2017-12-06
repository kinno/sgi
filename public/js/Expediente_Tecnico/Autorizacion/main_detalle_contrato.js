$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#guardar").on('click', function() {
        guardar();
    });
    $("#btnRegresar").on('click', function() {
        window.location = '/ExpedienteTecnico/Autorizacion/crear_autorizacion/' + $("#id_obra").val();
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
    $("#panel7").on('click', function() {
        $("#hojaActual").val('7');
    });
    $(".fecha").datepicker({
        language: "es",
        weekStart: 1,
        format: "dd-mm-yyyy",
        autoclose: true
    });
    $("#rfc").on('change', function() {
        buscarEmpresa();
    });
    $("#fecha_inicio").unbind("changeDate").on("changeDate", function(selected) {
        if (selected.date) {
            $("#fecha_fin").datepicker('setStartDate', new Date(selected.date.valueOf()));
            $("#fecha_fin").datepicker('setDate', new Date(selected.date.valueOf()));
            $("#fecha_fin").datepicker('update');
        }
    });
    $("#fecha_fin").unbind("changeDate").on("changeDate", function(selected) {
        if (selected.date) {
            var fechaInicio = new Date($("#fecha_inicio").datepicker("getDate"));
            var fechaTermino = new Date(selected.date);
            var tiempo = fechaTermino.getTime() - fechaInicio.getTime();
            var dias = Math.floor(tiempo / (1000 * 60 * 60 * 24));
            //console.log(dias);
            $("#dias_calendario").val(dias);
        } else {
            $("#dias_calendario").val("");
        }
    });
    $("#bdisponibilidad_inmueble").on('change', function(event) {
        if ($("#bdisponibilidad_inmueble").val() == 1) {
            $("#rowMotivos").hide();
            $("#fecha_disponibilidad").val('');
            $("#motivo_no_disponible").val('');
        } else {
            $("#rowMotivos").show();
        }
    });
    if ($("#id_contrato").val() !== '') {
        buscarContrato();
    }
});

function guardar() {
    switch ($("#hojaActual").val()) {
        case '1':
            if (validar_errores('form_general')) {
                guardarDatosGenerales();
            } else {
                BootstrapDialog.mensaje(null, "Se deben llenar los campos obligatorios.", 3);
            }
            break;
        case '2':
            if ($("#id_contrato").val() !== "") {
                guardarConceptosContrato();
            } else {
                BootstrapDialog.mensaje(null, "Se deben guardar primero los Datos Generales del contrato.", 3);
            }
            break;
        case '3':
            if ($("#id_contrato").val() !== "") {
                if(validar_errores('form_garantias')){
                    guardarGarantias();
                }else{
                    BootstrapDialog.mensaje(null, "Existen errores en los siguientes campos:", 3);
                }
                
            } else {
                BootstrapDialog.mensaje(null, "Se deben guardar primero los Datos Generales del contrato.", 3);
            }
            break;
        case '4':
            if ($("#id_contrato").val() !== "") {
                guardarPrograma();
            } else {
                BootstrapDialog.mensaje(null, "Se deben guardar primero los Datos Generales del contrato.", 3);
            }
            break;
        case '5':
            if ($("#id_contrato").val() !== "") {
                 if(validar_errores('form_financiero')){
                    guardar_avance_financiero();
                }else{
                    BootstrapDialog.mensaje(null, "Existen errores en los siguientes campos:", 3);
                }
            } else {
                BootstrapDialog.mensaje(null, "Se deben guardar primero los Datos Generales del contrato.", 3);
            }
            break;
    }
}

function buscarEmpresa() {
    $.ajax({
        data: {
            rfc: $("#rfc").val(),
        },
        url: '/ExpedienteTecnico/Autorizacion/buscar_rfc',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            console.log(response);
            if (!response.error) {
                if (response) {
                    $("#id_empresa").val(response.id);
                    $("#padron_contratista").val(response.padron_contratista);
                    $("#nombre").val(response.nombre);
                    $("#nombre_representante").val(response.nombre_representante);
                    $("#cargo_representante").val(response.cargo_representante);
                    $("#bnueva_empresa").val('');
                    $("#padron_contratista, #nombre, #nombre_representante,#cargo_representante").prop('readonly', true);
                } else {
                    BootstrapDialog.confirm('¡Atención!', '<b>El RFC no existe<br>¿Deseas agregar una nueva Empresa?</b>.', function(result) {
                        if (result) {
                            $("#padron_contratista, #nombre, #nombre_representante,#cargo_representante").prop('readonly', false);
                            $("#bnueva_empresa").val(1);
                        } else {
                            $("#rfc").val('');
                            $("#padron_contratista, #nombre, #nombre_representante,#cargo_representante").prop('readonly', true);
                            $("#bnueva_empresa").val('');
                        }
                    })
                }
            } else {
                BootstrapDialog.mensaje(null, response.error, 3);
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function guardarDatosGenerales() {
    var valoresGenerales = $("#form_general").serialize();
    valoresGenerales += '&id_obra=' + $("#id_obra").val() + '&id_expediente_tecnico=' + $("#id_expediente_tecnico").val() + '&id_contrato=' + $("#id_contrato").val();
    $.ajax({
        data: valoresGenerales,
        url: '/ExpedienteTecnico/Autorizacion/guardar_contrato_datos_generales',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            var data = response;
            if (!data.error_validacion) {
                if (!data.error) {
                    BootstrapDialog.mensaje(null, "Datos generales del contrato guardados correctamente.", 1);
                    // $.notify("Datos guardados correctamente.", "success");
                    // desactivaNavegacion(false);
                    $("#id_contrato").val(data);
                } else {
                    BootstrapDialog.mensaje(null, data.error, 3);
                }
            } else {
                $.notify('Por favor llenar los campos seleccionados', "error");
                for (property in data.error_validacion) {
                    $("#" + property).parent().addClass('has-error');
                    // desactivaNavegacion(true);
                }
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function buscarContrato() {
    $.ajax({
        data: {
            'id_contrato': $("#id_contrato").val()
        },
        url: '/ExpedienteTecnico/Autorizacion/buscar_contrato',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            console.log(response);
            if (!response.error) {
                $("#numero_contrato").val(response.numero_contrato);
                $("#fecha_celebracion").val(response.fecha_celebracion);
                $("#descripcion").val(response.d_contrato.descripcion);
                $("#id_empresa").val(response.empresa.id);
                $("#rfc").val(response.empresa.rfc);
                $("#padron_contratista").val(response.empresa.padron_contratista);
                $("#nombre").val(response.empresa.nombre);
                $("#nombre_representante").val(response.empresa.nombre_representante);
                $("#cargo_representante").val(response.empresa.cargo_representante);
                $("#id_tipo_contrato").val(response.d_contrato.id_tipo_contrato);
                $("#id_modalidad_adjudicacion_contrato").val(response.d_contrato.id_modalidad_adjudicacion_contrato);
                $("#monto").val(response.monto);
                $("#importe_garantia_cumplimiento").val(parseFloat(response.monto) * 0.1);
                $("#fecha_inicio").val(response.d_contrato.fecha_inicio);
                $("#fecha_fin").val(response.d_contrato.fecha_fin);
                $("#dias_calendario").val(response.d_contrato.dias_calendario);
                $("#bdisponibilidad_inmueble").val(response.d_contrato.bdisponibilidad_inmueble);
                $("#motivo_no_disponible").val(response.d_contrato.motivo_no_disponible);
                $("#fecha_disponibilidad").val(response.d_contrato.fecha_disponibilidad);
                $("#id_tipo_obra_contrato").val(response.d_contrato.id_tipo_obra_contrato);
                initDataConceptos(response.id);
                $("#folio_garantia").val(response.d_contrato.folio_garantia);
                $("#fecha_emision_garantia").val(response.d_contrato.fecha_emision_garantia);
                $("#importe_garantia").val(response.d_contrato.importe_garantia);
                $("#fecha_inicio_garantia").val(response.d_contrato.fecha_inicio_garantia);
                $("#fecha_fin_garantia").val(response.d_contrato.fecha_fin_garantia);
                $("#importe_anticipo").val(response.d_contrato.importe_anticipo);
                $("#porcentaje_anticipo").val(response.d_contrato.porcentaje_anticipo);
                $("#forma_pago_anticipo").val(response.d_contrato.forma_pago_anticipo);
                $("#folio_garantia_cumplimiento").val(response.d_contrato.folio_garantia_cumplimiento);
                $("#fecha_emision_garantia_cumplimiento").val(response.d_contrato.fecha_emision_garantia_cumplimiento);
                // $("#importe_garantia_cumplimiento").val(response.d_contrato.importe_garantia_cumplimiento);
                $("#fecha_inicio_garantia_cumplimiento").val(response.d_contrato.fecha_inicio_garantia_cumplimiento);
                $("#fecha_fin_garantia_cumplimiento").val(response.d_contrato.fecha_fin_garantia_cumplimiento);
                initDataPrograma(response.id);
                if (response.avance_financiero) {
                    $('#meseneAdmin').val(response.avance_financiero.enero);
                    $('#mesfebAdmin').val(response.avance_financiero.febrero);
                    $('#mesmarAdmin').val(response.avance_financiero.marzo);
                    $('#mesabrAdmin').val(response.avance_financiero.abril);
                    $('#mesmayAdmin').val(response.avance_financiero.mayo);
                    $('#mesjunAdmin').val(response.avance_financiero.junio);
                    $('#mesjulAdmin').val(response.avance_financiero.julio);
                    $('#mesagoAdmin').val(response.avance_financiero.agosto);
                    $('#messepAdmin').val(response.avance_financiero.septiembre);
                    $('#mesoctAdmin').val(response.avance_financiero.octubre);
                    $('#mesnovAdmin').val(response.avance_financiero.noviembre);
                    $('#mesdicAdmin').val(response.avance_financiero.diciembre).change();
                }
                $(".number").autoNumeric();
            } else {
                BootstrapDialog.mensaje(null, response.error, 3);
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function validar_errores(form){
    if($("#"+form+" .has-error").length >0){
        return false;
    }else{
        return true;
    }
}