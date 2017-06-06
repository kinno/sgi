var contadorNuevos = 0;
var table = "";
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // var tableDetail;
    // var template = Handlebars.compile($("#details-template").html());
    // var templateComentarios = Handlebars.compile($("#comentarios-template").html());
    initTable();
});

function initTable() {
    table = $('#tablaExpedientes').DataTable({
        "ordering": false,
        processing: true,
        serverSide: true,
         "destroy": true,
        ajax: '/ExpedienteTecnico/Revision/get_datos_revision',
        columns: [{
            data: 'id_expediente_tecnico',
            name: 'id_expediente_tecnico',
            render: function(data, type, full, meta) {
                return '<a href=/ExpedienteTecnico/impresion_expediente/' + data + ' target="_blank">' + data + '</a>';
            }
        }, {
            data: 'expediente.hoja1.nombre_obra',
            name: 'expediente.hoja1.nombre_obra'
        }, {
            data: 'expediente.hoja1.unidad_ejecutora.nombre',
            name: 'expediente.hoja1.unidad_ejecutora.nombre'
        }, {
            data: 'expediente.fecha_envio',
            name: 'expediente.fecha_envio'
        }, {
            data: 'expediente.tipo_solicitud.nombre',
            name: 'expediente.tipo_solicitud.nombre'
        }, {
            "className": 'mto',
            data: 'expediente.hoja1.monto',
            name: 'expediente.hoja1.monto'
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-success fa fa-check" title="Aceptar Expediente Técnico" style="cursor:hand;" onClick="aceptar(this);"></span>'
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-danger fa fa-share-square-o" title="Regresar con observaciones a Dependencia" style="cursor:hand;" onClick="observaciones(this);"></span>'
        }],
        "rowCallback": function(row, data, index) {
            // if (data.movimientos.length > 0) {
            // if (data.movimientos[0].id_tipo_movimiento === "2" || data.movimientos[0].id_tipo_movimiento === "3") {
            //     $(row).addClass('negrita');
            //     contadorNuevos++;
            // }
            // }
            $("#total").html(contadorNuevos);
            $("td:eq(1)", row).html("<span title='" + data.expediente.hoja1.nombre_obra + "'>" + data.expediente.hoja1.nombre_obra.substr(0, 100) + "...</span>");
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
}

function aceptar(elem) {
    var indiceEditar = table.row($(elem).parent().parent()).index();
    var datosFila = table.row(indiceEditar).data();
    BootstrapDialog.confirm('¡Atención!','<b>¿Deseas aceptar el Expediente Técnico?</b>', function(result) {
        if (result) {
            $.ajax({
                data: {
                    'id_expediente_tecnico': datosFila['id_expediente_tecnico'],
                    'estatus':6
                },
                url: '/ExpedienteTecnico/Revision/aceptar_expediente',
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
                       BootstrapDialog.mensaje(null, "El Expediente Técnico con folio: " + data.id_expediente_tecnico+" ha sido aceptado", 1,function(){
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

function observaciones(elem) {
    var indiceEditar = table.row($(elem).parent().parent()).index();
    var datosFila = table.row(indiceEditar).data();
    BootstrapDialog.confirm('Regresar Expediente Técnico con Observaciones a Dependencia','Observaciones: <textarea class="form-control" id="observaciones" placeholder="Ingrese las observaciones del Expediente Técnico..."></textarea>', function(result) {
        if (result) {
            $.ajax({
                data: {
                    'id_expediente_tecnico': datosFila['id_expediente_tecnico'],
                    'observaciones': $("#observaciones").val()
                },
                url: '/ExpedienteTecnico/Revision/regresar_observaciones',
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
                       BootstrapDialog.mensaje(null, "El Expediente Técnico con folio: " + data.id_expediente_tecnico+" ha sido regresado a la Dependencia", 1,function(){
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