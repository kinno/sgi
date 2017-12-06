var contadorNuevos = 0;
var table = "";
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    initTable();
});

function initTable() {
    table = $('#tablaAp').DataTable({
        "ordering": false,
        processing: true,
        serverSide: true,
        "destroy": true,
        ajax: '/AutorizacionPago/get_datos_listado',
        columns: [{
            data: 'id',
            name: 'id',
        }, {
            data: 'id_obra',
            name: 'id_obra'
        }, {
            data: 'clave',
            name: 'clave'
        }, {
            data: 'tipo_ap.nombre',
            name: 'tipo_ap.nombre'
        }, {
            "className": 'mto',
            data: 'monto',
            name: 'monto'
        }, {
            data: 'estatus.nombre',
            name: 'estatus.nombre'
        }, {
            'data': null,
            'defaultContent': '',
            render: function(data, type, full, meta) {
                if (full.estatus.id == "4") {
                    return '<span  class="btn btn-default fa fa-print" title="Imprimir Autorización de Pago" style="cursor:hand;" onClick="imprimir(this);"></span>';
                } else {
                    return '';
                }
            }
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-success fa fa-info-circle" title="Ver Detalle" style="cursor:hand;" onClick="detalle(this);"></span>'
        }, {
            "data": null,
            "defaultContent": '',
            render: function(data, type, full, meta) {
                if (full.estatus.id == "4") {
                    return '<span  class="btn btn-danger fa fa-trash-o" title="Eliminar Autorización de Pago" style="cursor:hand;" onClick="eliminar(this);"></span>';
                } else {
                    return '';
                }
            }
        }],
        "rowCallback": function(row, data, index) {
            // if (data.movimientos.length > 0) {
            // if (data.movimientos[0].id_tipo_movimiento === "2" || data.movimientos[0].id_tipo_movimiento === "3") {
            //     $(row).addClass('negrita');
            //     contadorNuevos++;
            // }
            // }
            // $("#total").html(contadorNuevos);
            // $("td:eq(1)", row).html("<span title='" + data.expediente.hoja1.nombre_obra + "'>" + data.expediente.hoja1.nombre_obra.substr(0, 100) + "...</span>");
        }
    });
    table.on('draw.dt', function() {
        $(".mto").each(function() {
            $(this).autoNumeric({
                aSep: ',',
                mDec: 2,
                vMin: '0.00'
            });
        });
    });
    table.column(0).visible(false);
}

function detalle(elem) {
    var indiceEditar = table.row($(elem).parent().parent()).index();
    var datosFila = table.row(indiceEditar).data();
    console.log(datosFila);
    // return;
    $.ajax({
        data: {
            'id': datosFila.id
        },
        url: '/AutorizacionPago/ver_detalle_ap_listado',
        type: 'post',
        beforeSend: function() {},
        complete: function() {},
        success: function(response) {
            // $("#divDetalle").load('/actualizar_head');
            $("#divDetalle").empty();
            $("#divDetalle").append(response);
            $("#modalDetalle").modal("show");
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function eliminar(elem) {
    var indiceEditar = table.row($(elem).parent().parent()).index();
    var datosFila = table.row(indiceEditar).data();
    BootstrapDialog.confirm('¡Atención!', '<b>¿Deseas eliminar la Autorización de Pago?</b>', function(result) {
        if (result) {
            $.ajax({
                data: {
                    'id': datosFila.id,
                },
                url: '/AutorizacionPago/eliminar_ap',
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
                        BootstrapDialog.mensaje(null, "La Autorización de Pago se ha eliminado con éxito.", 1, function() {
                            initTable();
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

function imprimir(elem) {
    var indiceEditar = table.row($(elem).parent().parent()).index();
    var datosFila = table.row(indiceEditar).data();
    window.open('/AutorizacionPago/imprimir_ap/' + datosFila.id + '', '_blank');
}