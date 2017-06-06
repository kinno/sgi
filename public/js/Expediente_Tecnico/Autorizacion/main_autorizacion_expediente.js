$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#buscar").on('click', function() {
        if ($("#id_obra_search").val() == "") {
            $("#id_obra_search").notify("Se debe introducir la Obra a buscar");
        } else {
            buscarObra($("#id_obra_search").val());
        }
    });
    $("#agregarContrato").on('click', function(event) {
        /* Act on the event */
    });
    // $("#registrarContrato").on('click', function() {
    //     // if($("#id_obra").val()==""){
    //     // }else{
    //     window.location.href = "crear_contrato/0" + $("#id_obra").val();
    //     // }
    // });
    $("#btnGenerarAutorizacion").on('click', function() {
        if ($("#id_obra").val() == "") {
        	$("#id_obra_search").notify("Se debe introducir la Obra a buscar");
        } else {
            generarAutorizacion($("#id_obra").val());
        }
    });
});

function buscarObra(id_obra) {
    $.ajax({
        data: {
            id_obra: id_obra,
        },
        url: '/ExpedienteTecnico/Autorizacion/buscar_obra',
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
                    $("#id_obra").val(response.id);
                    $("#id_solicitud_presupuesto").val(response.relacion.expediente.tipo_solicitud.nombre);
                    $("#ejercicio").val(response.ejercicio);
                    $("#monto").val(response.asignado);
                    $("#nombre_obra").val(response.nombre);
                    $("#unidad_ejecutora").val(response.unidad_ejecutora.nombre);
                    $("#sector").val(response.sector.nombre);
                    $("#sector").val(response.sector.nombre);
                    $("#modalidad_ejecucion").val(response.modalidad_ejecucion.nombre);
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

function generarAutorizacion(id_obra) {

    $.ajax({
        data: {
            id_obra: id_obra,
        },
        url: '/ExpedienteTecnico/Autorizacion/generar_autorizacion',
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
                    BootstrapDialog.mensaje(null, '', 1);
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