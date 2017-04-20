$(document).ready( function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$('body').on('click','#btnEliminar',function (){
		var id = $(this).attr('data-id');
		var msj = $(this).parent().parent().children().eq(1).text().trim();
        if (msj == '')
            msj = $(this).parent().parent().children().eq(2).text();
		msj = '<div><br>Menu: <strong>' + msj + '</strong></div>';
		BootstrapDialog.elimina ('Desea eliminar menu?', msj, function (respuesta) {
			if (respuesta)
				eliminaMenu (id);
		});
	});
});


function eliminaMenu (id) {
    $.ajax({
        data: {	id: id },
        url: '/Catalogo/Menu/' + id + '/destroy',
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
                	window.location='/Catalogo/Menu';
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