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
    // if (!validaHoja1()) {        
    //     return false;
    // }
    if ($("#form_anexo_uno #estudio_socioeconomico").val() != "") {
        $("#form_anexo_dos #id_estudio_socioeconomico").val($("#form_anexo_uno #estudio_socioeconomico").val());
        var formdata = new FormData($("form#form_anexo_dos")[0]);
        //append some non-form data also
        formdata.append('other_data', $("#form_anexo_dos #id_estudio_socioeconomico").val());
        $.ajax({
            data: formdata,
            url: '/EstudioSocioeconomico/guardar_hoja_2',
            type: 'post',
            processData: false,
            contentType: false,
             beforeSend:function(){
                $("#divLoading").show();
            },
            complete:function(){
                $("#divLoading").hide();
            },
            success: function(response) {
                console.log(response);
                var data = response;
                if (!data.error_validacion) {
                    if (!data.error) {
                        BootstrapDialog.mensaje (null, "Datos guardados correctamente.<br>Folio de Estudio Socioeconómico: "+data.id_estudio_socioeconomico, 1);
                        $("#estudio_socioeconomico").val(data.id_estudio_socioeconomico);
                        $("#id_hoja_dos").val(data.id_anexo_dos_estudio);
                        if (data.microlocalizacion) {
                            $("#vista_previa").attr('src', data.microlocalizacion);
                        }
                    } else {
                        BootstrapDialog.mensaje (null,data.error, 3);
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

function eliminarImagen() {
    var valoresh2 = $("#form_anexo_dos").serialize();
    $.ajax({
        data: valoresh2,
        url: '/EstudioSocioeconomico/eliminar_imagen',
        type: 'post',
        success: function(response) {
            console.log(response);
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}