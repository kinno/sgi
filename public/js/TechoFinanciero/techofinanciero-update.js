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
    $("#btnGuardar").removeAttr("disabled");
    $('.has-error').removeClass('has-error has-feedback');
    $("[id^='err_']" ).hide();
}


function Triggers () {
    // evento cambio, para ocultar error
    $('#monto, #observaciones').unbind("change").on('change', function (){
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
    var id = $('#id').val();
    var data = new FormData($("form#TechoFinanciero")[0]);   
    $("#btnGuardar").attr("disabled","disabled");
    $.ajax({
        data: data,
        url: '/TechoFinanciero/' + id,
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