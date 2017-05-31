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
    $("#id_fuente").on("change", function() {
        buscaTexto();
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
            name: 'fuentes.descripcion'
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
            data: 'id',
            name: 'id'
        }, {
            data: 'id_det_obra',
            name: 'id_det_obra'
        }, {
            data: 'principal_oficio.id_solicitud_presupuesto',
            name: 'id_tipo_solicitud'
        }, {
            data: 'principal_oficio.tipo_solicitud.nombre',
            name: 'solicitud'
        }, {
            data: 'id_fuente',
            name: 'id_fuente'
        }, {
            data: 'fuentes.descripcion',
            name: 'fuente'
        }, {
            data: 'monto',
            name: 'monto'
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-danger btn-sm fa fa-trash" title="Eliminar fuente" style="cursor:hand;" onClick="eliminar(this);"></span>'
        }],
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            var cell = tablaObras.cell(nRow, 6).node();
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
                    $("#fecha_oficio").val(response.fecha_oficio);
                    $("#titular").val(response.titular);
                    $("#asunto").val(response.asunto);
                    $("#ccp").val(response.ccp);
                    $("#prefijo").val(response.prefijo);
                    $("#tarjeta_turno").val(response.tarjeta_turno);
                    $("#iniciales").val(response.iniciales);
                    $("#texto").val(response.texto);
                    initDataOficios(response.id);
                }
            } else {
                $("#clave").notify(response.error, "error");
                $("#id_oficio").val();
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
            id_tipo_solicitud: $("#id_tipo_solicitud").val()
        },
        url: '/Oficios/buscar_obra',
        type: 'post',
        beforeSend: function() {
            // $("#divLoading").show();
        },
        complete: function() {
            // $("#divLoading").hide();
        },
        success: function(response) {
            if (!response.error) {
                if (response) {
                    $("#nombre_obra").val(response.nombre);
                    initDataFuentes($("#id_obra").val());
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
            id_tipo_solicitud: $("#id_tipo_solicitud").val(),
            solicitud: $("#id_tipo_solicitud option:selected").text(),
            id_fuente: datosFila['id_fuente'],
            fuente: datosFila['fuentes']['descripcion'],
            monto: datosFila['monto']
        }
        tablaObras.row.add(objObra).draw('false');
        // $("#id_fuente option").each(function() {
        //     if ($(this).val() == datosFila['id_fuente']) {
        //         tmp = true;
        //         return;
        //     } else {
        //         tmp = false;
        //     }
        // });
        // if (!tmp) {
        //     $('#id_fuente').append(new Option(datosFila['fuentes']['descripcion'], datosFila['id_fuente'], true, true));
        // }
    });
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
    var data = {
        'id_solicitud_presupuesto': $("#id_tipo_solicitud").val(),
        'ejercicio': $("#ejercicio").val(),
        'id_fuente': $("#id_fuente").val()
    }
    $.ajax({
        data: data,
        url: '/Oficios/buscar_texto',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            if (response) {
                $("#asunto").val(response.asunto);
                $("#prefijo").val(response.prefijo);
                $("#texto").val(response.texto);
            } else {
                $("#id").val("");
                $("#asunto").val("");
                $("#prefijo").val("");
                $("#texto").val("");
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
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
            console.log(response);
            if (!response.error) {
                var id = (response);
                if (id) {
                    for (var i = 0; i < id.length; i++) {
                        tablaObras.cell(i, 0).data(parseInt(id)).draw();
                    }
                    tablaObras.column(0).visible(false);
                    // eliminaWaitGeneral();
                    BootstrapDialog.mensaje(null, "Se guardo el Oficio: " + response.clave, 1);
                }
                console.log(tablaObras.data());
            } else {
                BootstrapDialog.mensaje(null, response.error, 3);
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}