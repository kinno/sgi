var tablaFuentes;
var tablaObras;
var arrayEliminados = [];
jQuery(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#id_obra, #id_tipo_solicitud, #ejercicio").on('change', function() {
        if ($("#id_obra").val() !== "") {
            $("#nombre_obra").val('');
            if ($.trim($("#id_obra").val()) !== "") {
                buscarObra();
            }
        }
    });
    initDataFuentes(0);
    initDataOficios(0);
    $("#btnAgregar").on("click", function() {
        agregarObra();
    });
    $("#btnTextos").on("click", function() {
        buscaTexto();
    });
    $("#limpiar").on('click', function() {
        location.reload();
    });
    $("#buscar").on('click', function() {
        buscarOficio();
    });
    $("#guardar").on('click', function() {
        guardarOficio();
    });
    $('#fecha_oficio').datepicker({
        language: "es",
        weekStart: 1,
        format: "dd-mm-yyyy",
        autoclose: true
    });
    $("#imprimir_oficio").on('click', function(event) {
        imprimeOficio($("#id_oficio").val());
    });
    $("#imprimir_detalle_oficio").on('click', function(event) {
        imprimeDetalleOficio($("#id_oficio").val());
    });
    $("#checkAll").change(function() {
        if ($(this).is(':checked')) {
            $(".seleccion").each(function() {
                $(this).prop("checked", true);
            });
        } else {
            $(".seleccion").each(function() {
                $(this).prop("checked", false);
            });
        }
    });
});

function initDataFuentes(id_det_obra) {
    tablaFuentes = $('#tablaFuentes').DataTable({
        "ordering": false,
        "paging": false,
        "info": false,
        "searching": false,
        "destroy": true,
        processing: false,
        serverSide: false,
        ajax: '/Oficios/get_data_fuentes/' + id_det_obra,
        columns: [{
            data: 'id_fuente',
            "render": function(data, type, full, meta) {
                return '<input type="checkbox" class="seleccion" name="touchbutton" value="' + data + '">';
            }
        }, {
            data: 'id_fuente',
            name: 'id_fuente'
        }, {
            data: 'fuentes.descripcion',
            name: 'descripcion'
        }, {
            data: 'tipo_fuente',
            name: 'tipo'
        }, {
            data: 'cuenta',
            name: 'cuenta'
        }, {
            data: 'monto',
            name: 'monto'
        }, {
            data: null,
            name: 'partida_presupuestal',
            "defaultContent": ''
        }, {
            data: 'asignado',
            name: 'asignado'
        }],
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            var cell = tablaFuentes.cell(nRow, 5).node();
            $(cell).addClass('number');
        },
        "drawCallback": function(settings) {
            $(".number").autoNumeric();
            $(".number").autoNumeric("update");
        }
    });
    tablaFuentes.column(1).visible(false); //ID 
    tablaFuentes.column(7).visible(false); //MONTO ASIGNADO 
    tablaFuentes.on('draw.dt', function() {
        $(".number").each(function() {
            $(this).autoNumeric({
                aSep: ',',
                mDec: 2,
                vMin: '0.00'
            });
        });
    });
}

function initDataOficios(id_oficio) {
    tablaObras = $('#tablaObras').DataTable({
        "ordering": false,
        "paging": false,
        "info": false,
        "searching": false,
        "destroy": true,
        processing: false,
        serverSide: false,
        ajax: '/Oficios/get_data_obras/' + id_oficio,
        columns: [{
            "data": 'id',
            "name": 'id'
        }, {
            "data": 'id_det_obra',
            "name": 'id_det_obra'
        }, {
            "data": 'id_solicitud_presupuesto',
            "name": 'id_tipo_solicitud'
        }, {
            "data": 'tipo_solicitud.nombre',
            "name": 'solicitud'
        }, {
            "data": 'id_fuente',
            "name": 'id_fuente'
        }, {
            "data": 'fuentes.descripcion',
            "name": 'fuente'
        }, {
            "data": 'id_unidad_ejecutora',
            "name": 'id_unidad_ejecutora'
        }, {
            "data": 'unidad_ejecutora.nombre',
            "name": 'unidad_ejecutora'
        }, {
            "data": 'monto',
            "name": 'monto'
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-danger btn-sm fa fa-trash" title="Eliminar fuente" style="cursor:hand;" onClick="eliminar(this);"></span>'
        }],
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            var cell = tablaObras.cell(nRow, 8).node();
            $(cell).addClass('number');
        },
        "drawCallback": function(settings) {
            $(".number").autoNumeric();
            $(".number").autoNumeric("update");
        }
    });
    tablaObras.column(0).visible(false); //ID 
    tablaObras.column(2).visible(false); //ID 
    tablaObras.column(4).visible(false); //ID 
    tablaObras.column(6).visible(false); //ID 
}

function buscarOficio() {
    $.ajax({
        data: {
            clave: $("#clave").val(),
        },
        url: '/Oficios/buscar_oficio',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            // console.log(response);
            if (!response.error) {
                if (response) {
                    $("#id_oficio").val(response.id);
                    $("#id_tipo_solicitud").val(response.id_solicitud_presupuesto);
                    $("#ejercicio").val(response.ejercicio);
                    $("#id_sector").val(response.id_sector);
                    $("#id_unidad_ejecutora").val(response.id_unidad_ejecutora);
                    $("#fecha_oficio").val(response.fecha_oficio);
                    $("#titular").val(response.titular);
                    $("#asunto").val(response.asunto);
                    $("#ccp").val(response.ccp);
                    $("#prefijo").val(response.prefijo);
                    $("#tarjeta_turno").val(response.tarjeta_turno);
                    $("#iniciales").val(response.iniciales);
                    $("#texto").val(response.texto);
                    initDataOficios(response.id);
                    $("#imprimir_oficio,#imprimir_detalle_oficio").show();
                }
            } else {
                $("#clave").notify(response.error, "error");
                $("#id_oficio").val();
                $("#imprimir_oficio #imprimir_detalle_oficio").hide();
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function buscarObra() {
    $.ajax({
        data: {
            id_obra: $("#id_obra").val(),
            id_tipo_solicitud: $("#id_tipo_solicitud").val(),
            id_sector: $("#id_sector").val(),
            id_unidad_ejecutora: $("#id_unidad_ejecutora").val()
        },
        url: '/Oficios/buscar_obra',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            if (!response.error) {
                if (response) {
                    // $("#tablaFuentes").show();
                    console.log(response);
                    $("#nombre_obra").val(response.nombre);
                    if (response.id_sector !== 4) {
                        $("#id_sector_tmp").val(response.id_sector);
                        $("#id_unidad_ejecutora_tmp").val('');
                    } else {
                        $("#id_unidad_ejecutora_tmp").val(response.id_unidad_ejecutora);
                        $("#id_sector_tmp").val('');
                    }
                    $("#id_unidad_ejecutora_select").val(response.id_unidad_ejecutora);
                    initDataFuentes(response.id);
                }
            } else {
                $("#id_obra").notify(response.error, "error");
                initDataFuentes();
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function agregarObra() {
    var arrayFtes = [];
    var tmp = false;
    // alert();
    $("#tablaFuentes").find(".seleccion:checked").each(function() {
        var indiceEditar = tablaFuentes.row($(this).parent().parent()).index();
        var datosFila = tablaFuentes.row(indiceEditar).data();
        var objObra = {
            id: null,
            id_det_obra: $("#id_obra").val(),
            id_solicitud_presupuesto: $("#id_tipo_solicitud").val(),
            tipo_solicitud: {
                nombre: $("#id_tipo_solicitud option:selected").text()
            },
            id_fuente: datosFila['id_fuente'],
            fuentes: {
                descripcion: datosFila['fuentes']['descripcion']
            },
            id_unidad_ejecutora: $("#id_unidad_ejecutora_select").val(),
            unidad_ejecutora: {
                nombre: $("#id_unidad_ejecutora_select option:selected").text()
            },
            monto: datosFila['monto']
        }
        tablaObras.row.add(objObra).draw('false');
        if ($("#id_tipo_solicitud").val() == "2") { //SI ES AUTORIZACIÓN VERIFICAR LOS MONTOS ASIGNAD Y AUTORIZADO PARA HACER REDUCCIÓN
            if (datosFila['monto'] < datosFila['asignado']) {
                var montoCancelacion = datosFila['asignado'] - datosFila['monto'];
                var objObra = {
                    id: null,
                    id_det_obra: $("#id_obra").val(),
                    id_solicitud_presupuesto: 7,
                    tipo_solicitud: {
                        nombre: "Cancelación"
                    },
                    id_fuente: datosFila['id_fuente'],
                    fuentes: {
                        descripcion: datosFila['fuentes']['descripcion']
                    },
                    id_unidad_ejecutora: $("#id_unidad_ejecutora_select").val(),
                    unidad_ejecutora: {
                        nombre: $("#id_unidad_ejecutora_select option:selected").text()
                    },
                    monto: montoCancelacion
                }
                tablaObras.row.add(objObra).draw('false');
            }
        }
    });
    var datosFila = tablaFuentes.row(0).data();
    $('#id_fuente').val(datosFila['id_fuente']);
    if ($("#id_sector_tmp").val() !== '') { // ES SECTOR DIFERENTE A AYUNTAMIENTOS
        $("#id_sector").val($("#id_sector_tmp").val());
        $("#id_sector_tmp").val('');
    } else { // ES SECTOR AYUNTAMIENTOS
        $("#id_unidad_ejecutora").val($("#id_unidad_ejecutora_tmp").val());
        $("#id_unidad_ejecutora_tmp").val('');
    }
    $("#nombre_obra").val('');
    $("#id_obra").val('');
    $("#id_unidad_ejecutora_select").val('');
    if ($("#checkAll").is(':checked')) {
        $("#checkAll").prop("checked", false);
    }
    tablaFuentes.clear().draw();
}

function eliminar(elem) {
    // bootbox.confirm("Se eliminar\u00e1 el concepto, \u00BFDesea Continuar?", function(response) {
    if (confirm("Se eliminar\u00e1 la fuente del oficio, \u00BFDesea Continuar?")) {
        var indiceEliminar = tablaObras.row($(elem).parent().parent()).index();
        var datosFila = tablaObras.row(indiceEliminar).data();
        if (datosFila['id'] !== "") {
            arrayEliminados.push(datosFila['id']);
        }
        tablaObras.row(indiceEliminar).remove().draw();
    }
    // });
}

function buscaTexto() {
    if (tablaObras.rows().data().length > 0) {
        var data = {
            'id_solicitud_presupuesto': $("#id_tipo_solicitud").val(),
            'ejercicio': $("#ejercicio").val(),
            'id_fuente': $("#id_fuente").val(),
            'id_sector': $("#id_sector").val(),
            'id_unidad_ejecutora': $("#id_unidad_ejecutora").val()
        }
        $.ajax({
            data: data,
            url: '/Oficios/cargar_textos',
            type: 'post',
            beforeSend: function() {
                $("#divLoading").show();
            },
            complete: function() {
                $("#divLoading").hide();
            },
            success: function(response) {
                // console.log(response);
                if (response) {
                    $("#asunto").val(response.texto.asunto);
                    $("#prefijo").val(response.texto.prefijo);
                    $("#texto").val(response.texto.texto);
                    $("#titular").val(response.titular);
                    $("#ccp").val(response.ccp);
                    $("#iniciales").val(response.iniciales);
                } else {
                    $("#id").val("");
                    $("#asunto").val();
                    $("#prefijo").val();
                    $("#texto").val();
                    $("#titular").val();
                    $("#ccp").val();
                    $("#iniciales").val();
                }
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    }
}

function guardarOficio() {
    var obras = [];
    var datosObras = tablaObras.rows().data();
    for (var i = 0; i < datosObras.length; i++) {
        obras.push(datosObras[i]);
    }
    var data = {
        'id': $("#id_oficio").val(),
        'id_solicitud_presupuesto': $("#id_tipo_solicitud").val(),
        'fecha_oficio': $("#fecha_oficio").val(),
        'ejercicio': $("#ejercicio").val(),
        'id_sector': $("#id_sector").val(),
        'id_unidad_ejecutora': $("#id_unidad_ejecutora").val(),
        'titular': $("#titular").val(),
        'asunto': $("#asunto").val(),
        'ccp': $("#ccp").val(),
        'prefijo': $("#prefijo").val(),
        'tarjeta_turno': $("#tarjeta_turno").val(),
        'iniciales': $("#iniciales").val(),
        'texto': $("#texto").val(),
        'obras': obras,
        'obras_eliminadas': arrayEliminados
    }
    $.ajax({
        data: data,
        url: '/Oficios/guardar',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            // console.log(response);
            if (!response.error) {
                var id = (response);
                if (id) {
                    for (var i = 0; i < id.length; i++) {
                        tablaObras.cell(i, 0).data(parseInt(id[i])).draw();
                    }
                    tablaObras.column(0).visible(false);
                    $("#id_oficio").val(response.id_oficio);
                    BootstrapDialog.mensaje(null, "Se guardo el Oficio: " + response.clave, 1, function() {
                        $("#imprimir_oficio,#imprimir_detalle_oficio").show();
                    });
                }
                // console.log(tablaObras.data());
            } else {
                BootstrapDialog.mensaje(null, response.error, 3);
                $("#imprimir_oficio,#imprimir_detalle_oficio").hide();
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function imprimeOficio(id_oficio) {
    if (id_oficio) {
        window.open('/Oficios/imprimir_oficio/' + id_oficio + '', '_blank');
    } else {
        $("#clave").notify("No se ha ingresado ningún Oficio", "warn");
    }
}

function imprimeDetalleOficio(id_oficio) {
    if (id_oficio) {
        window.open('/Oficios/imprimir_detalle_oficio/' + id_oficio + '', '_blank');
    } else {
        $("#clave").notify("No se ha ingresado ningún Oficio", "warn");
    }
}