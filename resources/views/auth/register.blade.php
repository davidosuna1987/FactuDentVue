@extends('layouts.auth')

@section('content')

<section class="guest-form floating-tooth-background">
    <h1 class="auth-title has-text-centered">Registro</h1>
    <div class="card">
        <div class="card-content">
            <form class="form" method="POST" action="{{ route('register') }}" role="form">
                {{ csrf_field() }}

                <div class="field{{ $errors->has('name') ? ' has-error' : '' }}">
                    <p class="control has-icons-left">
                        <input id="name" type="text" class="input is-small {{ $errors->has('name') ? 'is-danger' : '' }}" name="name" value="{{ old('name') }}" placeholder="Nombre" autofocus>
                        <span class="icon is-small is-left"><i class="fa fa-user"></i></span>

                        @if($errors->has('name'))
                            <p class="help is-danger">{{ $errors->first('name') }}</p>
                        @endif
                    </p>
                </div>

                <div class="field{{ $errors->has('surnames') ? ' has-error' : '' }}">
                    <p class="control has-icons-left">
                        <input id="surnames" type="text" class="input is-small {{ $errors->has('surnames') ? 'is-danger' : '' }}" name="surnames" value="{{ old('surnames') }}" placeholder="Apellidos">
                        <span class="icon is-small is-left"><i class="fa fa-user"></i></span>

                        @if($errors->has('surnames'))
                            <p class="help is-danger">{{ $errors->first('surnames') }}</p>
                        @endif
                    </p>
                </div>

                <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
                    <p class="control has-icons-left">
                        <input id="email" type="email" class="input is-small {{ $errors->has('email') ? 'is-danger' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-Mail">
                        <span class="icon is-small is-left"><i class="fa fa-at"></i></span>

                        @if($errors->has('email'))
                            <p class="help is-danger">{{ $errors->first('email') }}</p>
                        @endif
                    </p>
                </div>

                <div class="field{{ $errors->has('password') ? ' has-error' : '' }}">
                    <p class="control has-icons-left">
                        <input id="password" type="password" class="input is-small {{ $errors->has('password') ? 'is-danger' : '' }}" name="password" placeholder="Contraseña">
                        <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>

                        @if($errors->has('password'))
                            <p class="help is-danger">{{ $errors->first('password') }}</p>
                        @endif
                    </p>
                </div>

                <div class="field{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <p class="control has-icons-left">
                        <input id="password_confirmation" type="password" class="input is-small {{ $errors->has('password_confirmation') ? 'is-danger' : '' }}" name="password_confirmation" placeholder="Confirmar contraseña">
                        <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>

                        @if($errors->has('password_confirmation'))
                            <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                        @endif
                    </p>
                </div>

                <div class="control">
                    <button class="button is-primary is-small is-rounded m-t-10">Registrarme</button>
                </div>

                <p class="content is-small is-pulled-right m-t-10 m-b-10">
                    <a class="is-muted" href="{{ route('login') }}">¿Ya estás registrado? ¡Entra!</a>
                </p>
            </form>
        </div>
    </div>
</section>

@endsection
