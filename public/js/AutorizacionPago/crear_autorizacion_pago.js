var modalidad;
var fuentes = [];
var contrato = [];
var tablaFuentesAnticipo;
jQuery(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#limpiar").on('click', function() {
        location.reload();
    });
    $("#guardar").on('click', function() {
        guardarAp();
    });
    $(".number").autoNumeric('init', {
        mRound: 'D'
    })
    $("#accion").on('change', function() {
        if ($("#accion").val() == 1) {
            reiniciarInputs();
            $("#div_folio_ap").hide();
            $("#clave").val("");
            $("#div_id_obra, #div_ejercicio, #div_buscar").show();
        } else if ($("#accion").val() == 2) {
            reiniciarInputs();
            $("#div_id_obra").hide();
            $("#id_obra").val("");
            $("#div_folio_ap, #div_ejercicio, #div_buscar").show();
        }
    });
    $("#btnBuscar").on('click', function() {
        if ($("#id_obra").val() != "" || $("#clave").val() != "") {
            ($("#id_obra").val() != "") ? buscarObra(): buscarClave();
        }
    });
    $("#rfc").on('change', function() {
        buscarEmpresa();
    });
    $("#id_tipo").on('change', function() {
        cambiarTipo();
    });
    $("#id_contrato_anticipo").on('change', function() {
        calcularAnticipoFuentesContrato();
        if (contrato.length > 0 && $("#id_contrato_anticipo").val() !== "-1") {
            $("#rfc").val(contrato[$("#id_contrato_anticipo").val()].empresa.rfc);
            $("#id_empresa").val(contrato[$("#id_contrato_anticipo").val()].empresa.id);
            $("#padron_contratista").val(contrato[$("#id_contrato_anticipo").val()].empresa.padron_contratista);
            $("#nombre_representante").val(contrato[$("#id_contrato_anticipo").val()].empresa.nombre_representante);
            $("#cargo_representante").val(contrato[$("#id_contrato_anticipo").val()].empresa.cargo_representante);
            $("#nombre").val(contrato[$("#id_contrato_anticipo").val()].empresa.nombre);
        }
    });
    $("#id_fuente").on('change', function() {
        buscarMontoFuente();
    });
    $("#montoAnticipoAdm").on('change', function() {
        validaMontoAnticipoAdministracion();
    });
    $("#foliosAmortizar").on('change', function() {
        buscaMontoAmortizacion();
    });
    $("#montoParaAmortizar").on('change', function() {
        validaMontoAmortizacion();
    });
    $("#id_contrato").on('change', function() {
            if ($("#id_contrato").val() !== "-1") {
            buscarFolioAmortizar();
            $("#rfc").val(contrato[$("#id_contrato").val()].empresa.rfc);
            $("#id_empresa").val(contrato[$("#id_contrato").val()].empresa.id);
            $("#padron_contratista").val(contrato[$("#id_contrato").val()].empresa.padron_contratista);
            $("#nombre_representante").val(contrato[$("#id_contrato").val()].empresa.nombre_representante);
            $("#cargo_representante").val(contrato[$("#id_contrato").val()].empresa.cargo_representante);
            $("#nombre").val(contrato[$("#id_contrato").val()].empresa.nombre);
        } else {
            $("#rfc").val();
            $("#id_empresa").val();
            $("#padron_contratista").val();
            $("#nombre_representante").val();
            $("#cargo_representante").val();
            $("#nombre").val();
        }
    }); initTableFuentesAnticipo(); $("#sinivaAp").on('change', function() {
    calculaEstimacion();
}); $(".ret").each(function() {
    $(this).on('change', function() {
        calcularRetenciones();
    });
});
});

function initTableFuentesAnticipo() {
    tablaFuentesAnticipo = $('#tablaFuentesAnticipo').DataTable({
        "ordering": false,
        "paging": false,
        "info": false,
        "searching": false,
        "destroy": true,
        processing: false,
        serverSide: false,
        columns: [{
            data: 'id_fuente',
            name: 'id_fuente'
        }, {
            data: 'fuente',
            name: 'fuente'
        }, {
            data: 'cuenta',
            name: 'cuenta'
        }, {
            data: 'monto',
            name: 'monto'
        }, {
            data: 'folio',
            name: 'folio'
        }, {
            data: null,
            "defaultContent": '<span  class="btn btn-default btn-sm fa fa-file-text btnImpresionAnticipo" title="Imprimir Autorización" style="cursor:hand; display:none;" onClick="imprimirAp(this);"></span>'
        }],
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            var cell = tablaFuentesAnticipo.cell(nRow, 3).node();
            $(cell).addClass('number');
        },
        "drawCallback": function(settings) {
            $(".number").autoNumeric();
        }
    });
    tablaFuentesAnticipo.column(0).visible(false);
}

function buscarObra() {
    $.ajax({
        data: {
            id_obra: $("#id_obra").val(),
            ejercicio: $("#ejercicio_obra").val(),
        },
        url: '/AutorizacionPago/buscar_obra',
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
                reiniciarInputs();
                if (response.obra.id_modalidad_ejecucion == 3) { //Contrato
                    $("#id_tipo option[value=1]").hide();
                    $("#id_tipo option[value=4]").show();
                    modalidad = "contrato"
                    $('#id_contrato_anticipo').find('option').remove();
                    for (var i = 0; i < response.expediente.contrato.length; i++) {
                        $("#id_contrato_anticipo").append('<option value="-1">Seleccione...</option>');
                        if (response.expediente.contrato[i].d_contrato.importe_anticipo > 0) $("#id_contrato_anticipo").append('<option value="' + response.expediente.contrato[i].id + '">' + response.expediente.contrato[i].numero_contrato + '</option>');
                    }
                } else { //Administracion
                    $("#id_tipo option[value=1]").show();
                    $("#id_tipo option[value=4]").hide();
                    modalidad = "administracion";
                }
                $("#id_unidad_ejecutora").val(response.obra.unidad_ejecutora.id);
                $("#id_sector").val(response.obra.sector.id);
                $("#ejecutoraAp").val(response.obra.unidad_ejecutora.nombre);
                $("#modalidadEjecucion").val(response.obra.modalidad_ejecucion.nombre);
                $("#id_fuente, #id_contrato").append('<option value="-1">Seleccione...</option>');
                for (var i = 0; i < response.obra.fuentes.length; i++) {
                    fuentes.push(response.obra.fuentes[i]);
                    $("#id_fuente").append('<option value="' + response.obra.fuentes[i].id + '">' + response.obra.fuentes[i].descripcion + '</option>');
                }
                for (var i = 0; i < response.expediente.contrato.length; i++) {
                    contrato[response.expediente.contrato[i].id] = response.expediente.contrato[i];
                    $("#id_contrato").append('<option value="' + response.expediente.contrato[i].id + '">' + response.expediente.contrato[i].numero_contrato + '</option>')
                }
                // console.log(contrato);
            } else {
                BootstrapDialog.mensaje('¡Aviso!', response.error, 3)
                fuentes = [];
                contrato = [];
                // initDataFuentes();
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function buscarClave() {
    $.ajax({
        data: {
            folio: $("#clave").val(),
            ejercicio: $("#ejercicio_obra").val(),
        },
        url: '/AutorizacionPago/buscar_folio',
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
                reiniciarInputs();
                $("#id_ap").val(response.id);
                $("#folio_ap").val(response.clave);
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //  CONTRATO                
                if (response.obra.id_modalidad_ejecucion == 3) { //Contrato
                    $("#id_tipo option[value=1]").hide();
                    $("#id_tipo option[value=4]").show();
                    modalidad = "contrato"
                    $('#id_contrato_anticipo,#id_contrato').find('option').remove();
                    for (var i = 0; i < response.obra.relacion.expediente.contrato.length; i++) {
                        $("#id_contrato_anticipo,#id_contrato").append('<option value="-1">Seleccione...</option>');
                        if (response.obra.relacion.expediente.contrato[i].d_contrato.importe_anticipo > 0) $("#id_contrato_anticipo").append('<option value="' + response.obra.relacion.expediente.contrato[i].id + '">' + response.obra.relacion.expediente.contrato[i].numero_contrato + '</option>');
                    }
                }
                // END CONTRATO                
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //  ADMINISTRACION                
                else { //Administracion
                    $("#folio_ap").val(response.clave);
                    $("#id_tipo option[value=1]").show();
                    $("#id_tipo option[value=4]").hide();
                    modalidad = "administracion";
                }
                // END ADMINISTRACION                
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                
                $("#rfc").val(response.empresa.rfc);
                $("#padron_contratista").val(response.empresa.padron_contratista);
                $("#nombre").val(response.empresa.nombre);
                $("#nombre_representante").val(response.empresa.nombre_representante);
                $("#cargo_representante").val(response.empresa.cargo_representante);
                $("#bnueva_empresa").val('');
                $("#padron_contratista, #nombre, #nombre_representante,#cargo_representante").prop('readonly', true);
                $("#id_obra").val(response.id_obra);
                $("#id_unidad_ejecutora").val(response.obra.unidad_ejecutora.id);
                $("#id_sector").val(response.obra.sector.id);
                $("#ejecutoraAp").val(response.obra.unidad_ejecutora.nombre);
                $("#observaciones").val(response.observaciones);
                $("#modalidadEjecucion").val(response.obra.modalidad_ejecucion.nombre);
                $("#id_fuente").append('<option value="-1">Seleccione...</option>');
                for (var i = 0; i < response.obra.fuentes.length; i++) {
                    fuentes.push(response.obra.fuentes[i]);
                    $("#id_fuente").append('<option value="' + response.obra.fuentes[i].id + '">' + response.obra.fuentes[i].descripcion + '</option>');
                }
                for (var i = 0; i < response.obra.relacion.expediente.contrato.length; i++) {
                    contrato[response.obra.relacion.expediente.contrato[i].id] = response.obra.relacion.expediente.contrato[i];
                    $("#id_contrato").append('<option value="' + response.obra.relacion.expediente.contrato[i].id + '">' + response.obra.relacion.expediente.contrato[i].numero_contrato + '</option>')
                }
                $("#id_tipo").val(response.id_tipo_ap).change();
                if (response.id_tipo_ap == 2) {
                    $("#id_fuente").val(response.id_fuente).change();
                    $("#montoAnticipoAdm").val(response.monto);
                } else if (response.id_tipo_ap == 1) {
                    setTimeout(function() {
                        $('#foliosAmortizar').val(response.id_ap_amortizacion).change()
                    }, 500);
                    $("#montoParaAmortizar").val(response.monto_amortizacion).autoNumeric('update');
                } else if (response.id_tipo_ap = 4) {
                    $("#id_fuente").val(response.id_fuente).change();
                    $("#id_contrato").val(response.id_contrato).change();
                    $("#numero_estimacion").val(response.numero_estimacion);
                    $("#icicAp").val(response.icic);
                    $("#cmicAp").val(response.cmic);
                    $("#supervisionAp").val(response.supervision);
                    $("#isptAp").val(response.ispt);
                    $("#otroAp").val(response.otro);
                    $("#federal01Ap").val(response.federal_1);
                    $("#federal02Ap").val(response.federal_2);
                    $("#federal05Ap").val(response.federal_5);
                    setTimeout(function() {
                        $("#sinivaAp").val(response.importe_sin_iva).change()
                    }, 500);
                }
            } else {
                BootstrapDialog.mensaje('¡Aviso!', response.error, 3)
                fuentes = [];
                contrato = [];
                // initDataFuentes();
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
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

function cambiarTipo() {
    switch ($("#id_tipo").val()) {
        case '1':
            $("#layoutAmortizacion").show();
            $("#layoutAnticipo, #layoutEstimacion,#divContratos,#divFuentes").hide();
            buscarFolioAmortizar();
            break;
        case '2':
            if (modalidad == 'contrato') {
                $("#divContratoAnticipo,#divTablaFuentesAnticipo").show()
                $("#divAnticipoAdm,#divContratos,#divFuentes,#divAfectacion").hide()
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();
            } else {
                $("#divFuentes,#divAnticipoAdm").show()
                $("#divContratoAnticipo,#divTablaFuentesAnticipo,#divContratos,#divAfectacion").hide()
            }
            $("#layoutAnticipo").show();
            $("#layoutAmortizacion, #layoutEstimacion,#divContratos").hide();
            break;
        case '4':
            $("#layoutEstimacion,#divContratos,#divFuentes,#divAfectacion").show();
            $("#layoutAmortizacion, #layoutAnticipo").hide();
            break;
        default:
            $("#layoutAmortizacion,#layoutAnticipo, #layoutEstimacion,#divContratoAnticipo,#divTablaFuentesAnticipo,#divAnticipoAdm,#divContratos,#divFuentes,#divAfectacion").hide();
            break;
    }
}

function reiniciarInputs() {
    $('#id_tipo,#id_contrato_anticipo,#foliosAmortizar').val('-1').change();
    tablaFuentesAnticipo.clear().draw();
    // $("input[type=text]").each(function(){$(this).val("");});
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// AMORTIZACION
function buscarFolioAmortizar() {
    $.ajax({
        data: {
            'id_obra': $("#id_obra").val(),
            'ejercicio': $("#ejercicio_obra").val(),
            'id_contrato': $("#id_contrato").val() !== "-1" ? $("#id_contrato").val() : null,
            'id_fuente': $("#id_fuente").val() !== "-1" ? $("#id_fuente").val() : null
        },
        url: '/AutorizacionPago/buscar_folios_amortizacion',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            console.log(response);
            if (response) {
                if (modalidad == "administracion") {
                    $('#foliosAmortizar').find('option').remove();
                    $("#foliosAmortizar").append('<option value="-1">Seleccione...</option');
                    for (var i = 0; i < response.length; i++) {
                        $("#foliosAmortizar").append('<option value="' + response[i].id + '">' + response[i].clave + '</option');
                    }
                } else {
                    $("#folioAmortiza").val(response[0].clave);
                    $("#idFolioAmortiza").val(response[0].id);
                    buscarMontoPorEstimar();
                }
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function buscaMontoAmortizacion() {
    if ($("#foliosAmortizar").val() && $("#foliosAmortizar").val() !== "-1") {
        $.ajax({
            data: {
                'id_ap': ($("#id_ap").val()) ? $("#id_ap").val() : null,
                'folio_amortizar': $("#foliosAmortizar option:selected").text(),
                'id_obra': $("#id_obra").val(),
            },
            url: '/AutorizacionPago/buscar_monto_amortizacion',
            type: 'post',
            beforeSend: function() {
                $("#divLoading").show();
            },
            complete: function() {
                $("#divLoading").hide();
            },
            success: function(response) {
                console.log(response);
                $("#montoPorAmortizar").val(response[0]).autoNumeric('update');
                $("#id_fuente").val(response[1]);
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    }
}

function validaMontoAmortizacion() {
    var monto = parseFloat($("#montoParaAmortizar").val().replace(/,/g, ""));
    var montoDisponibleAmortizar = parseFloat($("#montoPorAmortizar").val().replace(/,/g, ""));
    // console.log(monto+"::"+montoDisponibleFuente);
    if (monto > montoDisponibleAmortizar) {
        $('.notifyjs-wrapper').trigger('notify-hide');
        $.notify('Se superó el monto disponible por a amortizar.', {
            position: "right bottom",
            className: "error",
            autoHide: false
        });
        $("#montoParaAmortizar").parent().addClass('has-error');
    } else {
        $("div").find('.has-error').each(function() {
            $(this).removeClass('has-error');
        });
        $('.notifyjs-wrapper').trigger('notify-hide');
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ANTICIPO
function calcularAnticipoFuentesContrato() {
    if ($("#id_contrato_anticipo").val() !== "-1" && $("#id_contrato_anticipo").val()) {
        $.ajax({
            data: {
                'id_contrato': $("#id_contrato_anticipo").val(),
            },
            url: '/AutorizacionPago/buscar_ap_anticipo_contrato',
            type: 'post',
            beforeSend: function() {
                $("#divLoading").show();
            },
            complete: function() {
                $("#divLoading").hide();
            },
            success: function(response) {
                console.log(response);
                if (response == 0) {
                    var montoTotalContrato = contrato[$("#id_contrato_anticipo").val()].monto;
                    var montoAnticipo = contrato[$("#id_contrato_anticipo").val()].d_contrato.importe_anticipo;
                    var montoFuente = 0;
                    for (var i = 0; i < fuentes.length; i++) {
                        montoFuente = parseFloat(((fuentes[i].pivot.monto * 100) / montoTotalContrato) * montoAnticipo / 100).toFixed(2);
                        var objFuente = {
                            id_fuente: fuentes[i].id,
                            fuente: fuentes[i].descripcion,
                            cuenta: fuentes[i].pivot.cuenta,
                            monto: montoFuente,
                            folio: null,
                        }
                        tablaFuentesAnticipo.row.add(objFuente).draw('false');
                    }
                } else {
                    BootstrapDialog.mensaje('¡Aviso!', "Ya existe una Autorizacion de Pago de Anticipo para esa Fuente y ese Contrato", 3);
                    $('#id_contrato_anticipo').val('-1').change();
                }
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    } else {
        tablaFuentesAnticipo.clear().draw();
    }
}

function validaMontoAnticipoAdministracion() {
    var monto = parseFloat($("#montoAnticipoAdm").val().replace(/,/g, ""));
    var montoDisponibleFuente = parseFloat($("#montoDisponibleObraAdm").val().replace(/,/g, ""));
    // console.log(monto+"::"+montoDisponibleFuente);
    if (monto > montoDisponibleFuente) {
        $('.notifyjs-wrapper').trigger('notify-hide');
        $.notify('Se superó el monto disponible para esa fuente.', {
            position: "right bottom",
            className: "error",
            autoHide: false
        });
        $("#montoAnticipoAdm").parent().addClass('has-error');
    } else {
        $("div").find('.has-error').each(function() {
            $(this).removeClass('has-error');
        });
        $('.notifyjs-wrapper').trigger('notify-hide');
    }
}
//END ANTICIPO
function buscarMontoFuente() {
    $.ajax({
        data: {
            'id_obra': $("#id_obra").val(),
            'id_fuente': $("#id_fuente").val(),
            'id_tipo_ap': $("#id_tipo").val(),
            'id_ap': ($("#id_ap").val()) ? $("#id_ap").val() : null,
        },
        url: '/AutorizacionPago/buscar_monto_fuente',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            console.log(response);
            if ($("#id_tipo").val() == "2") { // ANTICIPO ADMINISTRACION
                var montoDisponible = 0.00;
                for (var i = 0; i < fuentes.length; i++) {
                    if (fuentes[i].id == $("#id_fuente").val()) {
                        montoDisponible = parseFloat(fuentes[i].pivot.autorizado - response);
                        $("#montoObraAdm").val(fuentes[i].pivot.autorizado);
                        $("#montoDisponibleObraAdm").val(montoDisponible);
                        $(".number").autoNumeric('update');
                    }
                }
            } else if ($("#id_tipo").val() == "4") { //ESTIMACION
                var montoDisponible = 0.00;
                for (var i = 0; i < fuentes.length; i++) {
                    if (fuentes[i].id == $("#id_fuente").val()) {
                        montoDisponible = parseFloat(fuentes[i].pivot.autorizado - response);
                        $("#disponibleFuenteEstimacion").val(montoDisponible);
                        $(".number").autoNumeric('update');
                    }
                }
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ESTIMACION
function buscarMontoPorEstimar() {
    $.ajax({
        data: {
            'id_obra': $("#id_obra").val(),
            'id_contrato': $("#id_contrato").val(),
            'id_fuente': $("#id_fuente").val(),
            'id_ap': ($("#id_ap").val()) ? $("#id_ap").val() : null,
        },
        url: '/AutorizacionPago/buscar_monto_estimar',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            console.log(response);
            if (response) {
                var montoTotalContrato = contrato[$("#id_contrato").val()].monto;
                montoTotalContrato = montoTotalContrato / 1.16;
                var porEstimar = montoTotalContrato - response;
                $("#montoPorEstimar").val(porEstimar);
                $(".number").autoNumeric('update');
                buscaMontoPorAmortizar();
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function buscaMontoPorAmortizar() {
    if ($("#folioAmortiza").val() !== "") {
        $.ajax({
            data: {
                'id_ap': ($("#id_ap").val()) ? $("#id_ap").val() : null,
                'folio_amortizar': $("#folioAmortiza").val(),
                'id_obra': $("#id_obra").val(),
            },
            url: '/AutorizacionPago/buscar_monto_amortizacion',
            type: 'post',
            beforeSend: function() {
                $("#divLoading").show();
            },
            complete: function() {
                $("#divLoading").hide();
            },
            success: function(response) {
                console.log(response);
                $("#montoPorAmortizarEstimacion").val(response[0]).autoNumeric('update');
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    }
}

function calculaEstimacion() {
    var importeSinIva = 0.00;
    var amortizacion = 0.00;
    var ivaAmortizacion = 0.00;
    var subtotal = 0.00;
    var iva = 0.00;
    var afectacionPresupuestal = 0.00;
    var disponible = $("#disponibleFuenteEstimacion").val().replace(/,/g, "");
    importeSinIva = parseFloat($("#sinivaAp").val().replace(/,/g, ""));
    amortizacion = ($("#folioAmortiza").val() !== "") ? (importeSinIva * 30) / 100 : 0.00;
    // amortizacion = parseFloat(amortizacion.toFixed(2));
    ivaAmortizacion = amortizacion * 0.16;
    // ivaAmortizacion = parseFloat(ivaAmortizacion.toFixed(2));
    subtotal = parseFloat(importeSinIva - amortizacion);
    iva = subtotal * 0.16;
    // iva = parseFloat(iva.toFixed(2));
    afectacionPresupuestal = parseFloat(subtotal + iva);
    if (afectacionPresupuestal > disponible) {
        console.log(afectacionPresupuestal + "::" + disponible);
        BootstrapDialog.mensaje('¡Error!', "Afectación Presupuestal es mayor al monte disponible de la fuente", 3);
        $("#sinivaAp").parent().addClass('has-error');
    } else {
        $("#divAfectacion").find('.has-error').each(function() {
            $(this).removeClass('has-error');
        });
    }
    $("#amortizacionAp").val(amortizacion);
    $("#ivaAmortizacion").val(ivaAmortizacion);
    $("#subtotalAp").val(subtotal);
    $("#ivaAp").val(iva);
    $("#afectacionAp").val(afectacionPresupuestal);
    $(".number").autoNumeric('update');
    calcularRetenciones();
}

function calcularRetenciones() {
    var icic = 0.00;
    var cmic = 0.00;
    var supervision = 0.00;
    var ispt = 0.00;
    var otro = 0.00;
    var federal01 = 0.00;
    var federal02 = 0.00;
    var federal05 = 0.00;
    var totalRetenciones = 0.00;
    var afectacionPresupuestal = parseFloat($("#afectacionAp").val().replace(/,/g, ""));
    icic = parseFloat($("#icicAp").val().replace(/,/g, ""));
    cmic = parseFloat($("#cmicAp").val().replace(/,/g, ""));
    supervision = parseFloat($("#supervisionAp").val().replace(/,/g, ""));
    ispt = parseFloat($("#isptAp").val().replace(/,/g, ""));
    otro = parseFloat($("#otroAp").val().replace(/,/g, ""));
    federal01 = parseFloat($("#federal01Ap").val().replace(/,/g, ""));
    federal02 = parseFloat($("#federal02Ap").val().replace(/,/g, ""));
    federal05 = parseFloat($("#federal05Ap").val().replace(/,/g, ""));
    totalRetenciones = icic + cmic + supervision + ispt + otro + federal01 + federal02 + federal05;
    $("#totalAp").val(totalRetenciones);
    $("#netoAp").val(afectacionPresupuestal - totalRetenciones);
    $(".number").autoNumeric('update');
}
//  END ESTIMACION
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function guardarAp() {
    var data;
    switch ($("#id_tipo").val()) {
        case '1':
            //AMORTIZACION
            var anticiposObj = [];
            objAp = {
                'id': ($("#id_ap").val()) ? $("#id_ap").val() : null,
                'id_tipo_ap': $("#id_tipo").val(),
                'id_obra': $("#id_obra").val(),
                'ejercicio': $("#ejercicio_obra").val(),
                'id_fuente': $("#id_fuente").val(),
                'id_empresa': $("#id_empresa").val(),
                'rfc': $("#rfc").val(),
                'id_unidad_ejecutora': $("#id_unidad_ejecutora").val(),
                'id_sector': $("#id_sector").val(),
                'monto': 0.00,
                'importe_sin_iva': $("#montoParaAmortizar").val(),
                'monto_amortizacion': $("#montoParaAmortizar").val(),
                'monto_iva_amortizacion': 0.00,
                'folio_amortizacion': $("#foliosAmortizar option:selected").text(),
                'id_ap_amortizacion': $("#foliosAmortizar").val(),
            }
            anticiposObj.push(objAp);
            data = anticiposObj;
            break;
        case '2':
            //ANTICIPO
            if (modalidad == "contrato") {
                var anticipo_fuente = tablaFuentesAnticipo.rows().data();
                var anticiposObj = [];
                for (var i = 0; i < anticipo_fuente.length; i++) {
                    objAp = {
                        'id': ($("#id_ap").val()) ? $("#id_ap").val() : null,
                        'id_tipo_ap': $("#id_tipo").val(),
                        'id_obra': $("#id_obra").val(),
                        'ejercicio': $("#ejercicio_obra").val(),
                        'id_fuente': anticipo_fuente[i].id_fuente,
                        'id_contrato': $("#id_contrato_anticipo").val(),
                        'id_empresa': $("#id_empresa").val(),
                        'rfc': $("#rfc").val(),
                        'id_unidad_ejecutora': $("#id_unidad_ejecutora").val(),
                        'id_sector': $("#id_sector").val(),
                        'monto': anticipo_fuente[i].monto,
                        'importe_sin_iva': anticipo_fuente[i].monto
                    }
                    anticiposObj.push(objAp);
                }
                data = anticiposObj;
            } else {
                var anticiposObj = [];
                objAp = {
                    'id': ($("#id_ap").val()) ? $("#id_ap").val() : null,
                    'id_tipo_ap': $("#id_tipo").val(),
                    'id_obra': $("#id_obra").val(),
                    'ejercicio': $("#ejercicio_obra").val(),
                    'id_fuente': $("#id_fuente").val(),
                    'id_empresa': $("#id_empresa").val(),
                    'bnueva_empresa': $("#bnueva_empresa").val(),
                    'rfc': $("#rfc").val(),
                    'padron_contratista': $("#padron_contratista").val(),
                    'nombre': $("#nombre").val(),
                    'nombre_representante': $("#nombre_representante").val(),
                    'cargo_representante': $("#cargo_representante").val(),
                    'id_unidad_ejecutora': $("#id_unidad_ejecutora").val(),
                    'id_sector': $("#id_sector").val(),
                    'monto': $("#montoAnticipoAdm").val(),
                    'importe_sin_iva': $("#montoAnticipoAdm").val()
                }
                anticiposObj.push(objAp);
                data = anticiposObj;
            }
            break;
        case '4':
            //ESTIMACIÓN
            var estimacionObj = [];
            objAp = {
                'id': ($("#id_ap").val()) ? $("#id_ap").val() : null,
                'id_tipo_ap': $("#id_tipo").val(),
                'id_obra': $("#id_obra").val(),
                'ejercicio': $("#ejercicio_obra").val(),
                'id_fuente': $("#id_fuente").val(),
                'id_contrato': $("#id_contrato").val(),
                'id_empresa': $("#id_empresa").val(),
                'rfc': $("#rfc").val(),
                'id_unidad_ejecutora': $("#id_unidad_ejecutora").val(),
                'id_sector': $("#id_sector").val(),
                'monto': $("#afectacionAp").val(),
                'monto_amortizacion': $("#amortizacionAp").val(),
                'monto_iva_amortizacion': $("#ivaAmortizacion").val(),
                'folio_amortizacion': $("#folioAmortiza").val(),
                'id_ap_amortizacion': $("#idFolioAmortiza").val(),
                'importe_sin_iva': $("#sinivaAp").val(),
                'iva': $("#ivaAp").val(),
                'icic': $("#icicAp").val(),
                'cmic': $("#cmicAp").val(),
                'supervision': $("#supervisionAp").val(),
                'ispt': $("#isptAp").val(),
                'otro': $("#otroAp").val(),
                'federal_1': $("#federal01Ap").val(),
                'federal_2': $("#federal02Ap").val(),
                'federal_5': $("#federal05Ap").val(),
                'numero_estimacion': $("#numero_estimacion").val() ? $("#numero_estimacion").val() : null,
                'observaciones': $("#observaciones").val(),
            }
            estimacionObj.push(objAp);
            data = estimacionObj;
            break;
    }
    // console.log(data);
    // return;
    $.ajax({
        data: {
            'data': data,
            'tipo_ap': $("#id_tipo").val(),
            'modalidad': modalidad
        },
        url: '/AutorizacionPago/guardar_ap',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            console.log(response);
            if (!response.error_validacion) {
                if (!response.error) {
                    if ($("#id_tipo").val() == "2" && modalidad == "contrato") {
                        for (var i = 0; i < response.length; i++) {
                            tablaFuentesAnticipo.cell(i, 4).data(response[i][1]).draw();
                        }
                        BootstrapDialog.mensaje(null, "Autorizaciones de Pago generadas exitosamente.", 1);
                        $(".btnImpresionAnticipo").each(function() {
                            $(this).show();
                        })
                    } else {
                        for (var i = 0; i < response.length; i++) {
                            BootstrapDialog.mensaje(null, "Autorizacion de Pago generada exitosamente.<br>Folio:" + response[i][1], 1);
                            $("#folio_ap").val(response[i][1]);
                            $("#id_ap").val(response[i][0]);
                        }
                    }
                    $("#panelGeneral").find('.has-error').each(function() {
                        $(this).removeClass('has-error');
                    });
                } else {
                    BootstrapDialog.mensaje('¡Aviso!', response.error, 3)
                    fuentes = [];
                    contrato = [];
                    // initDataFuentes();
                }
            } else {
                $.notify('Por favor llenar los campos seleccionados', "error");
                for (property in response.error_validacion) {
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