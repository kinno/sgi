<!DOCTYPE html>
<html lang="es">
    <meta content="{{ csrf_token() }}" name="csrf-token">
        <head>
            <title>
                Sistema de Gasto de Inversión
            </title>
            <!-- Bootstrap Core CSS -->
            <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" rel="stylesheet">
            <!-- Bootstrap Core JavaScript -->
            <!-- <script crossorigin="anonymous" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
            </script> -->
            <link href="css/style_login.css" type="text/css" media="screen" rel="stylesheet" />    
        </head>
    </meta>
<div id="header">
    <h1><img src="images/header_institucional.png" alt="GEM" >
        Sistema de Gasto de Inversi&oacute;n
    </h1>
</div>

<div id="navigation">
    <ul>
        <li><a href="http://edomex.gob.mx/" target="_blank">GEM</a></li>

    </ul>
</div>
<br/> <br/><br/> <br/>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><strong>Ingresar al Sistema</strong></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <br/>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="usernam" class="col-md-3 control-label input-sm">Usuario:</label>
                            <div class="col-md-8">
                                <input id="username" type="text" class="form-control input-sm" name="username" value="{{ old('username') }}" required autofocus placeholder="Usuario">

                                @if ($errors->has('username'))
                                    <span class="help-block" style="font-size: 75%">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-3 control-label input-sm">Contraseña: </label>
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control input-sm" name="password" required placeholder="Contraseña">

                                @if ($errors->has('password'))
                                    <span class="help-block" style="font-size: 75%">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <br/>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-3">
                                <button type="submit">
                                    Ingresar
                                </button>

                                <!-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="footer">
    Subsecretar&iacute;a de Planeaci&oacute;n y Presupuesto - Direcci&oacute;n General de Inversi&oacute;n
</div>

</html>