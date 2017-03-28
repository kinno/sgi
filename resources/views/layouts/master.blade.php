<!DOCTYPE html>
<html lang="es">
    <meta content="{{ csrf_token() }}" name="csrf-token">
        <head>
            <title>
                Sistema de Gasto de Inversión
            </title>
            <!-- Bootstrap Core CSS -->
            <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" rel="stylesheet">
                <!-- MetisMenu CSS -->
                <link href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.6.2/metisMenu.css" rel="stylesheet"/>
                <!-- Custom CSS -->
                <link href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/dist/css/sb-admin-2.css" rel="stylesheet"/>
                <link href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.css" rel="stylesheet"/>
                <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
                
                <!-- Custom Fonts -->
                <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" rel="stylesheet"/>
                <!-- jQuery -->
                <script crossorigin="anonymous" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" src="https://code.jquery.com/jquery-3.1.1.js">
                </script>
                <!-- Bootstrap Core JavaScript -->
                <script crossorigin="anonymous" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
                </script>
                <!-- Metis Menu Plugin JavaScript -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.6.2/metisMenu.js">
                </script>
                <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js">
                </script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.js">
                </script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/1.9.46/autoNumeric.js">
                </script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js">
                </script> 
                {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.js">
                </script> --}}
            </link>
            <link rel="stylesheet" href="/css/bootstrap-dialog.css">
            <script src="/js/bootstrap-dialog.js"></script>
        </head>
    </meta>
</html>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
            @include('layouts.header-panel')
        @include('layouts.menu-izquierdo')
        </nav>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
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
