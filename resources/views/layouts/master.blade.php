<!DOCTYPE html>
<html lang="es">
    <meta content="{{ csrf_token() }}" name="csrf-token">
        <head>
            <title>
                Sistema de Gasto de Inversión
            </title>
            <link href="/css/bootstrap.css" rel="stylesheet"/>
            {{-- <link href="/css/bootstrap-theme.css" rel="stylesheet"/> --}}
            <link href="/css/sb-admin.css" rel="stylesheet"/>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.css" rel="stylesheet"/>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
            <link href="/css/estilos.css" rel="stylesheet"/>
            <!-- Custom Fonts -->
            <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" rel="stylesheet"/>
            <!-- jQuery -->
            <script crossorigin="anonymous" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" src="https://code.jquery.com/jquery-3.1.1.js">
            </script>
            <!-- Bootstrap Core JavaScript -->
            <script src="/js/bootstrap.js">
            </script>
            
            {{--
            <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js">
            </script>
            --}}
            <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.js">
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/1.9.46/autoNumeric.js">
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js">
            </script>
           
            {{--
            <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.js">
            </script>
            --}}
            <link href="/css/generales.css" rel="stylesheet">
        </head>
    </meta>
</html>
<link href="/css/bootstrap-dialog.css" rel="stylesheet">
    <script src="/js/bootstrap-dialog.js">
    </script>
</link>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div id="hdr">
                @include('layouts.header-panel')
            </div>
            
                @include('layouts.menu-izquierdo')
        </nav>
        {{-- <div style="position: absolute; padding-bottom: 20%;"> --}}
            
        {{-- </div> --}}

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="col-md-12">
                    @include('layouts.header-menu')
                </div>
                <div style="padding-top: 3%;">
                    @yield('content')
                </div>                
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <div id="divLoading" style="display:none !important; background: rgba(79, 158, 0, .3);width:100%;height:100%;display:flex; z-index: 99999; position: fixed; top: 0">
    <div style="position: fixed; top: 50%;left:50%">
        <p>
            <i class="fa fa-spinner fa-pulse fa-5x fa-fw">
            </i>
            <h3>
                Cargando
            </h3>
        </p>
    </div>
</div>
</body>
