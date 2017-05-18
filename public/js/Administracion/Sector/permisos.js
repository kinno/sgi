$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    Triggers();
    LimpiaPermisos ();
});

function LimpiaPermisos () {
    var vacio ='<option value="0">- Selecciona</option>';
    if ($('#id_usuario').children().length > 1) {
        $('#id_usuario').val('0');
        $('input[name=Sector0]').prop('checked', false).change();
    }
    $("#btnGuardar").removeAttr("disabled");
    $("[id^='err_']" ).hide();

}


function Triggers () {
    // evento usuario
    $('#id_usuario').unbind("change").on('change', function (){
        $('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
        $('#err_' + $(this).attr('id')).hide();
        var id = $(this).val();
        if (id == '0')
            $('input[name=Sector0]').prop('checked', false).change();
        else {
            $.ajax({
                data: {
                    id: id
                },
                url: '/Administracion/Sector/dropdownUsuario',
                type: 'POST',
                success: function (data) {
                    //console.log(data);
                    $('#opciones_sector').children().html(data);
                },
                error: function(data) {
                    console.log("Errores::", data);
                }
            });
        }
    });

    // chkboxs de ejercicio
    $('body').on('change','#chkSector', function () {
        var x = $(this).attr('data-x');
        var y = $(this).attr('data-y');
        var checked = $(this).prop("checked");
        var i, n, n2;
        var name = $(this).attr('name');
        // Todo
        if (x == 0) {
            $('#opciones_sector input').prop('checked', checked);
        }
        // Menu
        else if (y == 0) {
            $('#opciones_sector [data-x = ' + x + ']').prop('checked', checked);
        }
        // Submenu
        else {
            n = $('#opciones_sector [name=' + name + ']').length;
            n2 = $('input[name=' + name + ']' + ':checked').length;
            // Menu
            if (!checked) {
                $('#opciones_sector [name=' + name + ']').eq(0).prop('checked', false);
            }
            else if (n == n2 + 1)
                $('#opciones_sector [name=' + name + ']').eq(0).prop('checked', true);
        }
        // Todo
        n =$('#opciones_sector input').length;
        n2 = $('input:checked').length;
        if (!checked)
            $('input[name=Sector0]').prop('checked', false);
        else if (n == n2 + 1)
            $('input[name=Sector0]').prop('checked', true);
    });

    // botón guardar
    $('#btnGuardar').unbind('click').on('click', function () {      
       guardaPermisos ();
   });
}

function guardaPermisos () {
    var id_usuario = $('#id_usuario').val(), ids = [];
    if (id_usuario == '0') {
        BootstrapDialog.mensaje (null,'Seleccione usuario', 3);
        return;
    }
    ids = getAllValues($('#opciones_sector input:checked'));
    //return;
    $("#btnGuardar").attr("disabled","disabled");
    $.ajax({
        data: {
            id_usuario: id_usuario,
            ids: ids
        },
        url: '/Administracion/Sector/guarda_permisos',
        type: 'POST',
        beforeSend:function(){
            $("#divLoading h3").text('Guardando . . .');
            $("#divLoading").show();
        },
        complete:function(){
            $("#btnGuardar").removeAttr("disabled");
            $("#divLoading").hide();
        },
        success: function(data) {
            console.log(data);
            if (!data.errores) {
                if (data.error == 1) {
                    BootstrapDialog.mensaje (null, data.mensaje, 1);
                } 
                else
                    BootstrapDialog.mensaje (null, data.mensaje, data.error);
            }
            else
                for (campo in data.errores) {
                    $("#" + campo).notify(data.errores[campo][0], "error");
                    $('#div_' + campo).addClass('has-error has-feedback');
                    $('#err_' + campo).show();
                }
        },
        error: function(data) {
            console.log("Errores::", data);
        }
    });
}

function getAllValues (lista) {
    var aValues = [];
    var n = lista.length;
    for(var i = 0; i < n; i++) {
        if (lista.eq(i).attr('data-y') != '0')
            aValues.push(lista.eq(i).attr('data-id'));
    }
    return aValues;
}

