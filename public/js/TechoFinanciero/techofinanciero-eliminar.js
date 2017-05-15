$(document).ready( function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$('body').on('click','#btnEliminar',function (){
		var id = $(this).attr('data-id');
        var msj = 'Monto: ' + $(this).parent().parent().children().eq(4).text() + 
            '<br> ' + $(this).parent().parent().children().eq(2).text();
		msj = '<div><strong>' + msj + '</strong></div>';
		BootstrapDialog.elimina ('Desea eliminar este monto?', msj, function (respuesta) {
			if (respuesta)
				eliminaTecho (id);
		});
	});
});


function eliminaTecho (id) {
    $.ajax({
        data: {	id: id },
        url: '/TechoFinanciero/' + id + '/destroy',
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
                	window.location='/TechoFinanciero';
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