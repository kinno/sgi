var tablaContratos;
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#limpiar").on('click', function() {
        window.location = '/ExpedienteTecnico/Autorizacion/crear_autorizacion/';
    });
    $("#enviar_revision").on('click', function() {
        enviar_revision();
    });
    $("#imprimir_contrato").on('click', function() {
        imprime_contrato($("#id_expediente_tecnico").val());
    });
    $("#observaciones").hide();
    $("#observaciones").on('click', function() {
        abrirObservaciones();
    });
    $("#buscar").on('click', function() {
        if ($("#id_obra_search").val() == "") {
            $("#id_obra_search").notify("Se debe introducir la Obra a buscar");
        } else {
            buscarObra($("#id_obra_search").val(), $("#ejercicio").val());
        }
    });
    $("#btnRegistrarContrato").on('click', function() {
        window.location = "/ExpedienteTecnico/Autorizacion/crear_contrato/" + $("#id_obra").val() + "/0";
    });
    $("#btnGenerarAutorizacion").on('click', function() {
        if ($("#id_obra").val() == "") {
            $("#id_obra_search").notify("Se debe introducir la Obra a buscar");
        } else {
            generarAutorizacion($("#id_obra").val());
        }
    });
    if ($("#id_obra_search").val() !== "") {
        buscarObra($("#id_obra_search").val(), $("#ejercicio").val());
    }
    $(".number").autoNumeric();
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

function buscarObra(id_obra, ejercicio) {
    $.ajax({
        data: {
            id_obra: id_obra,
            ejercicio: ejercicio,
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
                    if (response.relacion.expediente.id_tipo_solicitud == 1) {
                        if (response.relacion.expediente.id_estatus == 6) {
                            $("#divBotones").show();
                        } else {
                            BootstrapDialog.mensaje("Error", "La Solicitud de Asignación de la Obra No: " + response.id + " no ha sido aceptada por la Dirección General de Inversión.", 3);
                            return;
                        }
                    }
                    $("#id_obra").val(response.id);
                    $("#id_expediente_tecnico").val(response.relacion.id_expediente_tecnico);
                    $("#id_solicitud_presupuesto").val(response.relacion.expediente.tipo_solicitud.nombre);
                    $("#ejercicio").val(response.ejercicio);
                    $("#monto").val(response.asignado).autoNumeric("update");
                    $("#nombre_obra").val(response.nombre);
                    $("#unidad_ejecutora").val(response.unidad_ejecutora.nombre);
                    $("#sector").val(response.sector.nombre);
                    $("#sector").val(response.sector.nombre);
                    $("#modalidad_ejecucion").val(response.modalidad_ejecucion.nombre);
                    if (response.relacion.expediente.id_tipo_solicitud == 2 && (response.relacion.expediente.id_estatus == 1 || response.relacion.expediente.id_estatus == 5)) {
                        $("#divBotones").hide();
                        $("#listadoContratos").show();
                        initDataContratos(response.relacion.id_expediente_tecnico);
                        if (response.relacion.expediente.id_estatus == 5) {
                            $("#observaciones").show();
                        }
                    }
                    if (response.relacion.expediente.observaciones) {
                        $.each(response.relacion.expediente.observaciones, function(index, item) {
                            tablaObservaciones.row.add([item.observaciones, item.fecha_observacion]).draw();
                        })
                        $("#observaciones").show();
                    }
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
                    BootstrapDialog.mensaje(null, 'Se generó la solicitud de Autorización correctamente, por favor registrar los contratos.', 1);
                    $("#id_expediente_tecnico").val(response.id);
                    $("#divBotones").hide();
                    $("#listadoContratos").show();
                    initDataContratos(response.id);
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

function initDataContratos(id_expediente_tecnico) {
    if (!id_expediente_tecnico) {
        id_expediente_tecnico = 0;
    }
    tablaContratos = $('#tablaContratos').DataTable({
        "ordering": false,
        "paging": false,
        "info": false,
        "searching": false,
        "destroy": true,
        processing: false,
        serverSide: false,
        ajax: '/ExpedienteTecnico/Autorizacion/get_data_contratos/' + id_expediente_tecnico,
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'numero_contrato',
            name: 'numero_contrato'
        }, {
            data: 'fecha_celebracion',
            name: 'fecha_celebracion'
        }, {
            data: 'monto',
            name: 'monto'
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-success fa fa-pencil-square-o" title="Editar contrato" style="cursor:hand;" onClick="editar(this);"></span>'
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-danger fa fa-trash" title="Eliminar contrato" style="cursor:hand;" onClick="eliminar(this);"></span>'
        }],
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            var cell = tablaContratos.cell(nRow, 3).node();
            $(cell).addClass('number');
        },
        "drawCallback": function(settings) {
            $(".number").autoNumeric();
            $(".number").autoNumeric("update");
        }
    });
    tablaContratos.column(0).visible(false); //ID CONCEPTO
}

function editar(elem) {
    var indiceEditar = tablaContratos.row($(elem).parent().parent()).index();
    var datosFila = tablaContratos.row(indiceEditar).data();
    window.location = "/ExpedienteTecnico/Autorizacion/crear_contrato/" + $("#id_obra").val() + "/" + datosFila.id;
}

function eliminar(elem) {
    if (confirm("Se eliminar\u00e1 el contrato, \u00BFDesea Continuar?")) {
        var indiceEditar = tablaContratos.row($(elem).parent().parent()).index();
        var datosFila = tablaContratos.row(indiceEditar).data();
        $.ajax({
            data: {
                'id_contrato': datosFila.id,
            },
            url: '/ExpedienteTecnico/Autorizacion/eliminar_contrato',
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
                    BootstrapDialog.mensaje(null, "Se ha eliminado el contrato con éxito.", 1, function() {
                        // location.reload();
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
}

function enviar_revision() {
    BootstrapDialog.confirm('¡Atención!', '<b>¿Deseas enviar el Expediente Técnico a revisión a la DGI?</b><br> Una vez enviado ya no se podrán realizar cambios.', function(result) {
        if (result) {
            if (verificarMontos()) {
                $.ajax({
                    data: {
                        'id_expediente_tecnico': $("#id_expediente_tecnico").val(),
                        'id_obra': $("#id_obra").val()
                    },
                    url: '/ExpedienteTecnico/Autorizacion/enviar_revision',
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
            } else {
                BootstrapDialog.mensaje(null, "La suma del monto de los contratos es mayor al monto Asignado.", 3);
            }
        }
    });
}

function verificarMontos() {
    var datos = tablaContratos.rows().data();
    var sumaContratos = 0;
    var montoAsignado = parseFloat($("#monto").val().replace(/,/g, ""));
    for (var i = 0; i < datos.length; i++) {
        sumaContratos += parseFloat(datos[i].monto.replace(/,/g, ""));
    }
    // console.log(sumaContratos+":"+montoAsignado);
    if (sumaContratos > montoAsignado) {
        return false;
    } else {
        return true;
    }
}

function imprime_contrato(id_expediente_tecnico) {
    if (id_expediente_tecnico) {
        window.open('/ExpedienteTecnico/impresion_contrato/' + id_expediente_tecnico + '', '_blank');
    } else {
        $("#id_obra").notify("No se ha ingresado ninguna obra", "warn");
    }
}

function abrirObservaciones() {
    $("#modal_observaciones").modal("show");
}