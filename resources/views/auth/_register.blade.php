@extends('layouts.auth')

@section('content')

<section class="guest-form">
    <div class="background" style="background-image: url({{ asset('images/backgrounds/gabinete-herramientas.jpg')  }});"></div>
    <div class="form-container">
        <form class="form" method="POST" action="{{ route('register') }}" role="form">
            {{ csrf_field() }}

            <div class="field{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="label is-small">Nombre</label>

                <p class="control has-icons-left">
                    <input id="name" type="text" class="input is-small {{ $errors->has('name') ? 'is-danger' : '' }}" name="name" value="{{ old('name') }}" autofocus>
                    <span class="icon is-small is-left"><i class="fa fa-user"></i></span>

                    @if($errors->has('name'))
                        <p class="help is-danger">{{ $errors->first('name') }}</p>
                    @endif
                </p>
            </div>

            <div class="field{{ $errors->has('surnames') ? ' has-error' : '' }}">
                <label for="surnames" class="label is-small">Apellidos</label>

                <p class="control has-icons-left">
                    <input id="surnames" type="text" class="input is-small {{ $errors->has('surnames') ? 'is-danger' : '' }}" name="surnames" value="{{ old('surnames') }}">
                    <span class="icon is-small is-left"><i class="fa fa-user"></i></span>

                    @if($errors->has('surnames'))
                        <p class="help is-danger">{{ $errors->first('surnames') }}</p>
                    @endif
                </p>
            </div>

            <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="label is-small">E-Mail</label>

                <p class="control has-icons-left">
                    <input id="email" type="email" class="input is-small {{ $errors->has('email') ? 'is-danger' : '' }}" name="email" value="{{ old('email') }}">
                    <span class="icon is-small is-left"><i class="fa fa-at"></i></span>

                    @if($errors->has('email'))
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @endif
                </p>
            </div>

            <div class="field{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="label is-small">Contraseña</label>

                <p class="control has-icons-left">
                    <input id="password" type="password" class="input is-small {{ $errors->has('password') ? 'is-danger' : '' }}" name="password">
                    <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>

                    @if($errors->has('password'))
                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                    @endif
                </p>
            </div>

            <div class="field{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password_confirmation" class="label is-small">Confirmar contraseña</label>

                <p class="control has-icons-left">
                    <input id="password_confirmation" type="password" class="input is-small {{ $errors->has('password_confirmation') ? 'is-danger' : '' }}" name="password_confirmation">
                    <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>

                    @if($errors->has('password_confirmation'))
                        <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </p>
            </div>

            <div class="control">
                <button class="button is-primary is-small is-outlined m-t-10">Entrar</button>
            </div>

            <p class="content is-small is-pulled-right">
                <a class="is-muted" href="{{ route('login') }}">¿Ya estás registrado? ¡Entra!</a>
            </p>
        </form>
    </div>
</section>

@endsection
