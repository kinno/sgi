$(document).ready( function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$('body').on('click','#btnEliminar',function (){
		var id = $(this).attr('data-id');
		var msj = $(this).parent().parent().children().eq(2).text();
		msj = '<div><br>Ejecutora: <strong>' + msj + '</strong></div>';
		BootstrapDialog.elimina ('Desea eliminar U. Ejecutora?', msj, function (respuesta) {
			if (respuesta)
				eliminaEjecutora (id);
		});
	});
});


function eliminaEjecutora (id) {
    $.ajax({
        data: {	id: id },
        url: '/Catalogo/Ejecutora/' + id + '/destroy',
        type: 'POST',
        processData: false,
        contentType: false,
        beforeSend:function(){
            $("#divLoading h3").text('Eliminando . . .');
            $("#divLoading").show();
        },
        complete:function(){
            $("#divLoading").hide();
        },
        cache: false,
        success: function(data) {
            console.log(data);
            if (data.error == 1) {
                BootstrapDialog.mensaje (null, data.mensaje, 1, function () {
                	window.location='/Catalogo/Ejecutora';
                });
            } 
            else
                BootstrapDialog.mensaje (null, data.mensaje, data.error);
        },
        error: function(data) {
            console.log("Errores::", data);
        }
    });
}