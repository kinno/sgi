<html>
<head>
	<style>
		<style>
			@page { margin: 0px 0px}
			header { 
				position: fixed; top: -25px; left: 12px; right: -10px; /*background-color: lightblue;*/ height: 96px;
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
			body {
				margin-left: 12px; margin-top: 74px; margin-bottom: : 30px; margin-right: -10px;
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
			.par {
				background-color: transparent;
			}
			.impar {
				background-color: #E6E6E6;
			}
			.ejercicio {
				margin-bottom: 5px !important;
			}
			.grupo {
				font-size: 6.5px;
				padding: 3px 1px;
				font-weight: bold;
			}
			.obra {
				font-size: 6px;
				padding-left: 10px;
			}
			.fuente {
				font-size: 8px;
				font-weight: bold;
			}
			main table, main td {
				border-collapse: collapse;
				vertical-align: top;
			}
			footer { 
				position: fixed; bottom: -30px; left: 12px; right: -10px; /*background-color: lightblue;*/ height: 20px;
				font-size: 7px;
				text-align: left;
				vertical-align: top;
			}
			footer table {
				border-collapse: collapse;
				border-top: 0.5px solid #AAAAAA;
			}
			/*
			footer .pagenum:before {
				content: counter(page);
			}
			*/
			@font-face {
				font-family: gotham-book;
				src: url(fonts/Gotham-Book.ttf) format("truetype");
			}
			@font-face {
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
			$x = 740;
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
				<td width="6%" style="vertical-align: top";>
					<img src="images/gem.jpg" width="60" />
				</td>
				<td width="23%" class="gem">
					<b>Gobierno del Estado de México</b><br>
					Secretaría de Finanzas<br>
					Subsecretaría de Planeación y Presupuesto<br>
					Dirección General de Inversión
				</td>
				<td width="60%" class="titulo">
					<b>PROGRAMA DE ACCIONES PARA EL DESARROLLO<br><br>
					{!! $titulo !!}
					</b>
				</td>
				<td width="11%" style="vertical-align: top; padding-left: 10px">
					<img src="images/logo-derecha.jpg" width="84"/>
				</td>
			</tr>
		</table>
		<table width="100%" class="encabezado">
			<tr>
				<td width="22%" class="enc-tabla text-center">
					Ejercicio - Sector - U. Ejecutora<br>Fuente - Inversión
				</td>
				<td width="4%" class="enc-tabla text-right">
					Obras
				</td>
				<td width="9%" class="enc-tabla text-right">
					Asignado
				</td>
				<td width="9%" class="enc-tabla text-right">
					Autorizado
				</td>
				<td width="9%" class="enc-tabla text-right">
					Ejercido
				</td>
				<td width="9%" class="enc-tabla text-right">
					Por Ejercer
				</td>
				<td width="9%" class="enc-tabla text-right">
					Comprobado
				</td>
				<td width="9%" class="enc-tabla text-right">
					Por Comprobar
				</td>
				<td width="9%" class="enc-tabla text-right">
					Pagado
				</td>
				<td width="9%" class="enc-tabla text-right">
					Por pagar
				</td>
				<td width="2%" class="enc-tabla text-right">
					%
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
					switch ($registro['n_grupo']) {
						case 1:
							$clase = 'ejercicio grupo';
							break;
						case 2:
							$clase = 'grupo';
							$sector = $registro;
							$textos = ['POR FUENTE DE FINANCIAMIENTO', 'POR INVERSIÓN'];
							break;
						case 3:
							$clase = 'grupo';
							break;
						case 4:
							$clase = 'obra';
							break;
					}
				@endphp
				<tr {!! $registro['clase_row'] !!}>
					<td width="22%" class="{{$clase}} text-justify">{!!$registro['grupo']!!}</td>
					<td width="4%" class="{{$clase}} text-right">{{$registro['obras']}}</td>
					<td width="9%" class="{{$clase}} text-right">{{$registro['asignado']}}</td>
					<td width="9%" class="{{$clase}} text-right">{{$registro['autorizado']}}</td>
					<td width="9%" class="{{$clase}} text-right">{{$registro['ejercido']}}</td>
					<td width="9%" class="{{$clase}} text-right">{{$registro['por_ejercer']}}</td>
					<td width="9%" class="{{$clase}} text-right">{{$registro['comprobado']}}</td>
					<td width="9%" class="{{$clase}} text-right">{{$registro['por_comprobar']}}</td>
					<td width="9%" class="{{$clase}} text-right">{{$registro['pagado']}}</td>
					<td width="9%" class="{{$clase}} text-right">{{$registro['por_pagar']}}</td>
					<td width="2%" class="{{$clase}} text-right">{{$registro['av_fin']}}</td>
				</tr>
				@if (isset($registro['ultimo']))
					@for ($i = 0; $i <= 1; $i++)
					<tr class="grupo1 fuente">
						<td colspan="11" style="letter-spacing: 6px; margin-top: 15px !important" class="text-center">{{$textos[$i]}}</td>
					</tr>
					<tr class="grupo2">
						<td width="22%" class="grupo text-center">TOTAL DEL SECTOR</td>
						<td width="4%" class="grupo text-right">{{$sector['obras']}}</td>
						<td width="9%" class="grupo text-right">{{$sector['asignado']}}</td>
						<td width="9%" class="grupo text-right">{{$sector['autorizado']}}</td>
						<td width="9%" class="grupo text-right">{{$sector['ejercido']}}</td>
						<td width="9%" class="grupo text-right">{{$sector['por_ejercer']}}</td>
						<td width="9%" class="grupo text-right">{{$sector['comprobado']}}</td>
						<td width="9%" class="grupo text-right">{{$sector['por_comprobar']}}</td>
						<td width="9%" class="grupo text-right">{{$sector['pagado']}}</td>
						<td width="9%" class="grupo text-right">{{$sector['por_pagar']}}</td>
						<td width="2%" class="grupo text-right">{{$sector['av_fin']}}</td>
					</tr>
					@php
						$n = 0;
						if ($i == 0)
							$detalle = $sector['fuente'];
						else
							$detalle = $sector['inversion'];
					@endphp
					@foreach ($detalle as $key => $valor)
						@php
							if ($n % 2 == 0)
								$clase = 'par';
							else
								$clase = 'impar';
						@endphp
						<tr class="{{$clase}}">
							<td width="22%" class="obra"><b>{{$key}}</b></td>
							<td width="4%" class="obra text-right">{{$valor['obras']}}</td>
							<td width="9%" class="obra text-right">{{$valor['asignado']}}</td>
							<td width="9%" class="obra text-right">{{$valor['autorizado']}}</td>
							<td width="9%" class="obra text-right">{{$valor['ejercido']}}</td>
							<td width="9%" class="obra text-right">{{$valor['por_ejercer']}}</td>
							<td width="9%" class="obra text-right">{{$valor['comprobado']}}</td>
							<td width="9%" class="obra text-right">{{$valor['por_comprobar']}}</td>
							<td width="9%" class="obra text-right">{{$valor['pagado']}}</td>
							<td width="9%" class="obra text-right">{{$valor['por_pagar']}}</td>
							<td width="2%" class="obra text-right">{{$valor['av_fin']}}</td>
						</tr>
						@php
							$n++;
						@endphp
					@endforeach
					@endfor
				@endif
			@empty
				<tr class="impar">
					<td colspan="11" class="grupo text-center"><b>No existe información</b></td>
				</tr>
			@endforelse
		</table>
	</main>
	
</body>
</html>