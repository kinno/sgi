<html>
<head>
	<style>
		<style>
			@page { margin: 0px 0px}
			header { 
				position: fixed; top: -25px; left: 50px; right: -10px; /*background-color: lightblue;*/ height: 96px;
				font-size: 10px;
			}
			header table, header td {
				/*border-collapse: collapse;*/
				/*border: 1px solid black;*/
			}
			.gem {
				padding-top: 10px;
				padding-left: 2px;
				text-align: left;
				vertical-align: top;
			}
			.titulo {
				text-align: center;
				vertical-align: middle;
				height: 60px;
			}
			.encabezado {
				border-collapse: collapse;
				border-top: 1.5px solid #AAA;
				border-bottom: 1.5px solid #AAA;
				/*height: 20px;*/
				/*background-color: red;*/
			}
			.enc-tabla {
				font-size: 8px;
				font-weight: bold;
				padding-top: -1px;
				vertical-align: top;
			}
			.enc-tabla2 {
				font-size: 6px;
				font-weight: bold;
				vertical-align: top;
			}
			body {
				margin-left: 50px; margin-top: 74px; margin-bottom: : 30px; margin-right: -10px;
				/*font-size: 7px;*/
			}
			.grupo1 {
				background-color: #FF8080;
			}
			.grupo2 {
				background-color: #CDFFCD;
			}
			.grupo3 {
				background-color: #FFFFCD;
			}
			.grupo4 {
				background-color: #DDD9C3;
				/*font-size: 6.5px;*/
			}
			.par {
				background-color: transparent;
			}
			.impar {
				background-color: #E6E6E6;
			}
			.grupo {
				font-size: 6.5px;
				padding: 3px 1px;
			}
			.obra {
				font-size: 6.5px;
			}
			.obra2 {
				font-size: 5px;
			}
			main table, main td {
				border-collapse: collapse;
				vertical-align: top;
			}
			footer { 
				position: fixed; bottom: -30px; left: 50px; right: -10px; /*background-color: lightblue;*/ height: 20px;
				font-size: 7px;
				text-align: left;
				vertical-align: top;
			}
			footer table {
				border-collapse: collapse;
				border-top: 0.5px solid #AAAAAA;
			}
			footer .pagenum:before {
				content: counter(page);
				/*content: "Page " counter(page) " of " counter(pages);*/
			}
			@font-face {
				font-family: gotham-book;
				src: url(fonts/Gotham-Book.ttf) format("truetype");
			}
			@font-face {
				/*font-family: gotham-medium;
				src: url(fonts/GothamHTF-Bold.ttf) format("truetype");*/
				font-family: gotham-book;
				src: url(fonts/GothamHTF-Bold.ttf) format("truetype");
				font-weight: bold;
			}
			html{
				font-family: gotham-book;
			}
			.text-center {
				text-align: center;
			}
			.text-right {
				text-align: right;
			}
			.text-justify {
				text-align: justify;
			}
			.page-break {
				page-break-after: always;
			}
	</style>
	
</head>
<body>
	<script type="text/php">
		if ( isset($pdf) ) {
			$x = 955;
			$y = 586;
			$text = "{PAGE_NUM} de {PAGE_COUNT}";
			//$font = $fontMetrics->get_font("helvetica", "bold");
			$font = $fontMetrics->get_font("gotham-book", "bold");
			//$font = '';
			$size = 5;
			$color = array(0,0,0);
			$word_space = 0.0;  //  default
			$char_space = 0.0;  //  default
			$angle = 0.0;   //  default
			$pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
		}
	</script>
	<header>
		<table width="100%">
			<tr>
				<td width="5%" style="vertical-align: top";>
					<img src="images/gem.jpg" width="60" />
				</td>
				<td width="19%" class="gem">
					<b>Gobierno del Estado de México</b><br>
					Secretaría de Finanzas<br>
					Subsecretaría de Planeación y Presupuesto<br>
					Dirección General de Inversión
				</td>
				<td width="68%" class="titulo">
					<b>PROGRAMA DE ACCIONES PARA EL DESARROLLO<br><br>
					{!! $titulo !!}
					</b>
				</td>
				<td width="8%" style="vertical-align: top; padding-left: 10px">
					<img src="images/logo-derecha.jpg" width="84"/>
				</td>
			</tr>
		</table>
		<table width="100%" class="encabezado">
			<tr>
				<td width="22%" class="enc-tabla">
					Ejercicio - Sector - U. Ejecutora - Obra
				</td>
				<td width="3%" class="enc-tabla text-right">
					Obras
				</td>
				<td width="3%" class="enc-tabla text-center">
					Av. Fin.
				</td>
				<td width="5%" class="enc-tabla text-right">
					Asignado
				</td>
				<td width="5%" class="enc-tabla text-right">
					Autorizado
				</td>
				<td width="5%" class="enc-tabla text-right">
					Ejercido
				</td>
				<td width="5%" class="enc-tabla text-right">
					Por Ejercer
				</td>
				<td width="5%" class="enc-tabla text-right">
					Comprobado
				</td>
				<td width="5%" class="enc-tabla text-right">
					Por Comprobar
				</td>
				<td width="5%" class="enc-tabla text-right">
					Pagado
				</td>
				<td width="5%" class="enc-tabla text-right">
					Por pagar
				</td>
				<td width="4%" class="enc-tabla2 text-center">
					Oficio
				</td>
				<td width="3%" class="enc-tabla2 text-center">
					Firma
				</td>
				<td width="4%" class="enc-tabla2 text-right">
					Asignado
				</td>
				<td width="4%" class="enc-tabla2 text-right">
					Autorizado
				</td>
				<td width="3%" class="enc-tabla2 text-center">
					AP<br>
					Pago
				</td>
				<td width="3%" class="enc-tabla2 text-center">
					Tipo
				</td>
				<td width="3%" class="enc-tabla2 text-center">
					Envío <br>
					Fecha
				</td>
				<td width="4%" class="enc-tabla2 text-center">
					Afectación <br>
					Cheque
				</td>
				<td width="4%" class="enc-tabla2 text-right">
					Pagado <br>
					Monto
				</td>
			</tr>
		</table>
	</header>
	<footer>
		<table width="100%">
			<tr>
				<td width="30%">Generó: {{ $usuario->name}}</td>
				<td width="15%">SGI - dSecDepInv</td>
				<td width="20%">Generación: {{ $fecha}}</td>
				<td width="20%">Período: {{ $periodo }}</td>
				<td width="15%"></td>
			</tr>
		</table>	
	</footer>
	
	<main class="main">
		<table width="100%">
			@forelse ($tabla as $registro)
				@php
					if ($registro['n_grupo'] <= 3) {
						$clase0 = 'grupo';
						$clase = 'grupo';
						$clase2 = '';
					}
					else {
						$clase0 = 'obra';
						$clase = 'obra';
						$clase2 = 'obra2';
					}
				@endphp
				<tr {!! $registro['clase_row'] !!}>
					<td width="22%" class="{{$clase0}} text-justify">{!!$registro['grupo']!!}</td>
					<td width="3%" class="{{$clase}} text-right">{{$registro['obras']}}</td>
					<td width="3%" class="{{$clase}} text-right">{{$registro['av_fin']}}</td>
					<td width="5%" class="{{$clase}} text-right">{{$registro['asignado']}}</td>
					<td width="5%" class="{{$clase}} text-right">{{$registro['autorizado']}}</td>
					<td width="5%" class="{{$clase}} text-right">{{$registro['ejercido']}}</td>
					<td width="5%" class="{{$clase}} text-right">{{$registro['por_ejercer']}}</td>
					<td width="5%" class="{{$clase}} text-right">{{$registro['comprobado']}}</td>
					<td width="5%" class="{{$clase}} text-right">{{$registro['por_comprobar']}}</td>
					<td width="5%" class="{{$clase}} text-right">{{$registro['pagado']}}</td>
					<td width="5%" class="{{$clase}} text-right">{{$registro['por_pagar']}}</td>
					<td width="4%" class="{{$clase2}} text-center">{!!$registro['oficio']!!}</td>
					<td width="3%" class="{{$clase2}} text-center">{!!$registro['firma']!!}</td>
					<td width="4%" class="{{$clase2}} text-right">{!!$registro['asignado1']!!}</td>
					<td width="4%" class="{{$clase2}} text-right">{!!$registro['autorizado1']!!}</td>
					<td width="3%" class="{{$clase2}} text-right">{!!$registro['AP']!!}</td>
					<td width="3%" class="{{$clase2}} text-center">{{$registro['tipo']}}</td>
					<td width="3%" class="{{$clase2}} text-center">{!!$registro['envio']!!}</td>
					<td width="4%" class="{{$clase2}} text-right">{!!$registro['afectacion']!!}</td>
					<td width="4%" class="{{$clase2}} text-right">{!!$registro['pagado1']!!}</td>
				</tr>
			@empty
				<tr class="impar">
					<td colspan="20" class="grupo text-center"><b>No existe información</b></td>
				</tr>
			@endforelse
		</table>
	</main>
	
</body>
</html>