function llenarHoja6(id_expediente_tecnico, hoja6) {
    $("#form_anexo_seis #id_hoja_seis").val(hoja6.id);
    $("#form_anexo_seis #id_expediente_tecnico").val(id_expediente_tecnico);
    $("#criterios_sociales").val(hoja6.criterios_sociales);
    $("#unidad_ejecutora_normativa").val(hoja6.unidad_ejecutora_normativa);
}

function guardarHoja6() {
     if( $("#form_anexo_seis #id_expediente_tecnico").val()===""){
         $("#form_anexo_seis #id_expediente_tecnico").val( $("#form_anexo_uno #id_expediente_tecnico").val());
    }
    var valoresh6 = $("#form_anexo_seis").serialize();
    $.ajax({
        data: valoresh6,
        url: '/ExpedienteTecnico/Asignacion/guardar_hoja_6',
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
                    BootstrapDialog.mensaje(null, "Datos del Anexo 6 guardados correctamente.<br>Folio de Expediente Técnico: " + data.id_expediente_tecnico, 1);
                    // $.notify("Datos guardados correctamente.", "success");
                    $("#form_anexo_seis #id_expediente_tecnico").val(data.id_expediente_tecnico);
                    $("#id_hoja_seis").val(data.id_anexo_seis);
                } else {
                    BootstrapDialog.mensaje(null, data.error, 3);
                    // $.notify(data.error, "error");
                    if (data.error_validacion) {}
                }
            } else {
                for (property in data.error_validacion) {
                    $("#" + property).notify("Campo requerido", "error");
                }
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}