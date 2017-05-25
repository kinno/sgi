jQuery(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.numeroDecimal').autoNumeric({
        aSep: ',',
        mDec: 2,
        vMin: 0.00
    });
    Triggers ();
    LimpiaTechoFinanciero ();
});

function LimpiaTechoFinanciero () {
    //var vacio ='<option value="0">- Selecciona</option>';
    //$('#id_unidad_ejecutora, #programa, #id_proyecto_ep, #id_fuente').html(vacio);
    //$('#ejercicio, #id_sector, #id_unidad_ejecutora, #prograna, #id_proyecto_ep').val('0');
    //$('#id_tipo_fuente, #id_fuente, #id_tipo_movimiento').val('0');
    $('#monto, #observaciones').val('');
    $("#btnGuardar").removeAttr("disabled");
    $('.has-error').removeClass('has-error has-feedback');
    $("[id^='err_']" ).hide();
}


function Triggers () {
    var vacio ='<option value="0">- Selecciona</option>';
    // evento Ejercicio
    $('#ejercicio').unbind("change").on('change', function () {
        var ejercicio = $(this).val();
        $('#id_proyecto_ep').html(vacio);
        if (ejercicio == '0')
            $('#programa').html(vacio);
        else {
            $.ajax({
                data: {
                    ejercicio: ejercicio
                },
                url: '/TechoFinanciero/dropdownEjercicio',
                type: 'POST',
                success: function (data) {
                    console.log(data);
                    $('#programa').html(data[0]);
                    $('#id_proyecto_ep').html(data[1]);
                },
                error: function(data) {
                    console.log("Errores::", data);
                }
            });
            $('#div_ejercicio').removeClass('has-error has-feedback');
            $('#err_ejercicio').hide();
        }
    });

    // evento Sector
    $('#id_sector').unbind("change").on('change', function (){
        var id = $(this).val();
        if (id == '0')
            $('#id_unidad_ejecutora').html(vacio);
        else {
            $.ajax({
                data: {
                    id: id
                },
                url: '/TechoFinanciero/dropdownSector',
                type: 'POST',
                success: function (data) {
                    console.log(data);
                    /*$('#div_id_unidad_ejecutora').removeClass('has-error has-feedback');
                    $('#err_id_unidad_ejecutora').hide();*/
                    $('#id_unidad_ejecutora').html(data);
                },
                error: function(data) {
                    console.log("Errores::", data);
                }
            });
            $('#div_id_sector').removeClass('has-error has-feedback');
            $('#err_id_sector').hide();
        }
    });

    // evento Programa
    $('#programa').unbind("change").on('change', function (){
        var id = $(this).val();
        var ejercicio = $('#ejercicio').val();
        if (id == '0' || ejercicio == '0')
            $('#id_proyecto_ep').html(vacio);
        else {
            $.ajax({
                data: {
                    id: id,
                    ejercicio: ejercicio
                },
                url: '/TechoFinanciero/dropdownPrograma',
                type: 'POST',
                success: function (data) {
                    console.log(data);
                    /*$('#div_id_proyecto_ep').removeClass('has-error has-feedback');
                    $('#err_id_proyecto_ep').hide();*/
                    $('#id_proyecto_ep').html(data);
                },
                error: function(data) {
                    console.log("Errores::", data);
                }
            });
        }
    });

    // evento Tipo Fuente
    $('#id_tipo_fuente').unbind("change").on('change', function (){
        var id = $(this).val();
        if (id == '0')
            $('#id_fuente').html(vacio);
        else {
            $.ajax({
                data: {
                    id: id
                },
                url: '/TechoFinanciero/dropdownTipoFuente',
                type: 'POST',
                success: function (data) {
                    console.log(data);
                    $('#id_fuente').html(data);
                },
                error: function(data) {
                    console.log("Errores::", data);
                }
            });
            $('#div_id_tipo_fuente').removeClass('has-error has-feedback');
            $('#err_id_tipo_fuente').hide();
        }
    });

    // evento cambio, para ocultar error
    $('#id_unidad_ejecutora, #id_proyecto_ep, #id_fuente, #id_tipo_movimiento, #monto, #observaciones').unbind("change").on('change', function (){
        $('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
        $('#err_' + $(this).attr('id')).hide();
    });

    // botón guardar
    $('#btnGuardar').unbind('click').on('click', function () {      
        guardaTechoFinanciero ();
    });

    // botón Regresar
    $('#btnRegresar').unbind('click').on('click', function () {      
        window.location='/TechoFinanciero';
    });
}


function guardaTechoFinanciero () {
    var data = new FormData($("form#TechoFinanciero")[0]);   
    $("#btnGuardar").attr("disabled","disabled");
    $.ajax({
        data: data,
        url: '/TechoFinanciero',
        type: 'POST',
        processData: false,
        contentType: false,
        beforeSend:function(){
            $("#divLoading h3").text('Guardando . . .');
            $("#divLoading").show();
        },
        complete:function(){
            $("#btnGuardar").removeAttr("disabled");
            $("#divLoading").hide();
        },
        cache: false,
        success: function(data) {
            console.log(data);
            if (!data.errores) {
                if (data.error == 1) {
                    BootstrapDialog.mensaje (null, data.mensaje, 1, function () {
                        window.location='/TechoFinanciero';
                    });
                } 
                else
                    BootstrapDialog.mensaje (null, data.mensaje, data.error);
            } 
            else
                for (campo in data.errores) {
                    $("#" + campo).notify(data.errores[campo], "error");
                    $('#div_' + campo).addClass('has-error has-feedback');
                    $('#err_' + campo).show();
                }
        },
        error: function(data) {
            console.log("Errores:: ", data);
        }
    });
}