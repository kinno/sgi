$(document).ready(function() {
    $("#id_cobertura").on('change', function() {
        switch ($(this).val()) {
            case '1': //Estatal
                $("#divRegiones,#divMunicipios").hide();
                $("#id_region,#id_municipio").val([]);
                $('#comloc').hide(0, function() {
                    $("#nombre_localidad").val('');
                });
                break;
            case '2': //Regional
                $("#divRegiones").show(0, function() {
                    $("#id_region").select2({
                        placeholder: "Seleccione la(s) región(es)"
                    });
                    $("#divMunicipios").hide(0);
                });
                $("#id_municipio").val([]);
                $('#comloc').show(0);
                break;
            case '3': //Municipal
                $("#divRegiones").hide(0);
                $("#divMunicipios").show(0, function() {
                    $("#id_municipio").select2({
                        placeholder: "Seleccione el(los) municipio(s)"
                    });
                });
                $("#id_region").val([]);
                $('#comloc').show(0);
                break;
            default:
                $("#divRegiones,#divMunicipios").hide(0);
                $("#id_region,#id_municipio").val([]);
                $('#comloc').hide(0, function() {
                    $("#nombre_localidad").val('');
                });
                break;
        }
    });
    $("#bcoordenadas").on('change', function() {
        if ($(this).val() == 1) { //si
            $('#coordenadas').removeAttr('hidden');
            $('#observaciones_coordenadas').attr('readonly', true);
            $("#observaciones_coordenadas").val('');
            //initMap();
        } else if ($(this).val() == 2) { //no
            $('#coordenadas').attr('hidden', 'hidden');
            $('#observaciones_coordenadas').attr('readonly', false);
            document.getElementById('label3').innerText = 'Escribir motivo por el cual no se capturan coordenadas';
            $("#latitud_inicial").val('');
            $("#latitud_final").val('');
            $("#longitud_inicial").val('');
            $("#longitud_final").val('');
        } else { //sin seleccionar
            $('#coordenadas').attr('hidden', 'hidden');
            $('#observaciones_coordenadas').attr('readonly', true);
            $("#observaciones_coordenadas").val('');
            document.getElementById('label3').innerText = '';
            $("#latitud_inicial").val('');
            $("#latitud_final").val('');
            $("#longitud_inicial").val('');
            $("#longitud_final").val('');
        }
    });
    $("#microlocalizacion").filestyle({
        buttonText: " Cargar Imagen",
        buttonName: "btn-success",
        buttonBefore: true,
        iconName: "fa fa-file-image-o"
    });
    $("#borrar_imagen").on('click', function(event) {
        if (confirm("¿Desea eliminar la imagen?")) {
            if ($("#vista_previa").attr("src")) {
                $("#vista_previa").attr("src", '');
                $("#microlocalizacion").val("");
                eliminarImagen();
            } else {
                $.notify("No hay imagen para eliminar", {
                    position: "right"
                });
            }
        }
    });
});

function guardarHoja2() {
    if ($("#form_anexo_uno #id_expediente_tecnico").val() != "") {
        $("#form_anexo_dos #id_expediente_tecnico").val($("#form_anexo_uno #id_expediente_tecnico").val());
        var formdata = new FormData($("form#form_anexo_dos")[0]);
        //append some non-form data also
        formdata.append('other_data', $("#form_anexo_dos #id_expediente_tecnico").val());
        $.ajax({
            data: formdata,
            url: '/ExpedienteTecnico/guardar_hoja_2',
            type: 'post',
            processData: false,
            contentType: false,
            beforeSend: function() {
                $("#divLoading").show();
            },
            complete: function() {
                $("#divLoading").hide();
            },
            success: function(response) {
                console.log(response);
                var data = response;
                if (!data.error_validacion) {
                    if (!data.error) {
                        BootstrapDialog.mensaje(null, "Datos del Anexo 2 guardados correctamente.<br>Folio de Expediente Técnico: " + data.id_expediente_tecnico, 1);
                        $("#id_expediente_tecnico").val(data.id_expediente_tecnico);
                        $("#id_hoja_dos").val(data.id_anexo_dos);
                        if (data.microlocalizacion) {
                            $("#vista_previa").attr('src', data.microlocalizacion);
                        }
                    } else {
                        BootstrapDialog.mensaje(null, data.error, 3);
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
    } else {
        $.notify("Se debe capturar y guardar primero el Anexo Uno", "warn");
    }
    // 
}

function llenarHoja2(id_expediente_tecnico, hoja2, regiones, municipios,rutaReal,tipo) {
    if(tipo=="estudio"){
        var disabled = true;
    }else{
        disabled = false;
    }
    $("#form_anexo_dos #id_hoja_dos").val(hoja2.id);
    $("#form_anexo_dos #id_expediente_tecnico").val(id_expediente_tecnico);
    $("#form_anexo_dos #id_cobertura").val(hoja2.id_cobertura).prop('readonly', disabled);
    if (regiones.length > 0) {
        $("#divRegiones").show(0, function() {
            arrRegiones = [];
            for (var i = 0; i < regiones.length; i++) {
                // arrRegiones.push(regiones[i].id_region);
                arrRegiones.push(regiones[i].id);
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
                arrMunicipios.push(municipios[i].id);
            }
            $("#id_municipio").select2({
                placeholder: "Seleccione la(s) región(es)"
            });
            $(".select2-container").css({
                width: '100%',
            });
            $("#id_municipio").val(arrMunicipios).trigger('change').prop('readonly', disabled);
        });
        $("#comloc").show();
    }
    $("#form_anexo_dos #nombre_localidad").val(hoja2.nombre_localidad).prop('readonly', disabled);
    $("#form_anexo_dos #id_tipo_localidad").val(hoja2.id_tipo_localidad).prop('readonly', disabled);
    $("#form_anexo_dos #bcoordenadas").val(hoja2.bcoordenadas).change().prop('readonly', disabled);
    $("#form_anexo_dos #observaciones_coordenadas").val(hoja2.observaciones_coordenadas).prop('readonly', disabled);
    $("#form_anexo_dos #latitud_inicial").val(hoja2.latitud_inicial).prop('readonly', disabled);
    $("#form_anexo_dos #longitud_inicial").val(hoja2.longitud_inicial).prop('readonly', disabled);
    $("#form_anexo_dos #latitud_final").val(hoja2.latitud_final).prop('readonly', disabled);
    $("#form_anexo_dos #longitud_final").val(hoja2.longitud_final).prop('readonly', disabled);
    if (hoja2.microlocalizacion) {
        $("#form_anexo_dos #vista_previa").attr('src',rutaReal + "/" + hoja2.microlocalizacion);
    }
}

function eliminarImagen() {
    var valoresh2 = $("#form_anexo_dos").serialize();
    $.ajax({
        data: valoresh2,
        url: '/ExpedienteTecnico/eliminar_imagen',
        type: 'post',
        success: function(response) {
            console.log(response);
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}