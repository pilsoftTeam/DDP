@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Direccion E-Mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Contraseña</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Ingresa
                                    </button>

                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                        ¿ Olvidaste tu contraseña ?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <img src="{{asset('/img/Logo_Fortunato.png')}}" class="img-responsive" style="margin: 0 auto"
                     width="500" height="400">
            </div>

        </div>
        <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            <div class="col-xs-18 col-sm-10 col-md-10 col-lg-10">
                <div class="alert alert-default" style="border: 1px solid #D3E0E9">
                    <h4><strong style="color :red;"> Importante:</strong></h4>
                    <p style="font-size: 14pt">Para efectos de recepción de correos electrónicos, producto de la
                        finalización de la revisión de un
                        formulario o checklist por parte de un auditor en terreno, es necesario que la cuenta de usuario
                        del sistema
                        sea creado utilizando un nombre de casilla <b>“válido”</b> Ej. lfloresb@fortunato.cl.
                    </p>
                    <hr>
                    <p style="font-size: 14pt">
                        Lo anterior es muy importante, considerando que el sistema enviará un correo automático a ésta
                        casilla
                        notificando sobre la finalización de una revisión en terreno.
                        El correo remitente designado para esta demo es auditores@fortunato.cl-
                        <b>Para crear la cuenta de usuario recuerde utilizar la cuenta admin@sistema.cl</b>
                    </p>


                </div>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        </div>


    </div>
@endsection
