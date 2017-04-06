$(document).ready(function() {
    /*$("#id_usuario,#id_modulo").select2({
        placeholder: "Seleccione una acción"
    });*/
    LimpiaPermisos ();
});

function LimpiaPermisos () {
    var vacio ='<option value="0">- Selecciona</option>';
    $('#id_usuario, #id_modulo').val('0');
    //$('#id_usuario, #id_modulo').val(null).change();
    $("#btnGuardar").removeAttr("disabled");
    $("[id^='err_']" ).hide();
    //$('#id_tipo_usuario').change();
}