$(document).ready( function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$('body').on('click','#btnEliminar',function (){
		var id = $(this).attr('data-id');
		var msj = $(this).parent().parent().children().eq(1).text();
		msj = '<div><br>Sector: <strong>' + msj + '</strong></div>';
		BootstrapDialog.elimina ('Desea eliminar sector?', msj, function (respuesta) {
			if (respuesta)
				eliminaSector (id);
		});
	});
});


function eliminaSector (id) {
    $.ajax({
        data: {	id: id },
        url: '/Catalogo/Sector/' + id + '/destroy',
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
                	window.location='/Catalogo/Sector';
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