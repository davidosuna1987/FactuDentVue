@extends('layouts.auth')

@section('content')

<section class="guest-form floating-tooth-background">
    <h1 class="auth-title has-text-centered">Recuperación</h1>
    <div class="card">
        <div class="card-content">
            @if (session('status'))
                <div class="notification is-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form" method="POST" action="{{ route('password.request') }}" role="form">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
                    <p class="control has-icons-left">
                        <input id="email" type="email" class="input is-small {{ $errors->has('email') ? 'is-danger' : '' }}" name="email" value="{{ old('email') }}" required placeholder="E-Mail" autofocus>
                        <span class="icon is-small is-left"><i class="fa fa-at"></i></span>

                        @if($errors->has('email'))
                            <p class="help is-danger">{{ $errors->first('email') }}</p>
                        @endif
                    </p>
                </div>

                <div class="field{{ $errors->has('password') ? ' has-error' : '' }}">
                    <p class="control has-icons-left">
                        <input id="password" type="password" class="input is-small {{ $errors->has('password') ? 'is-danger' : '' }}" name="password" required placeholder="Contraseña">
                        <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>

                        @if($errors->has('password'))
                            <p class="help is-danger">{{ $errors->first('password') }}</p>
                        @endif
                    </p>
                </div>

                <div class="field{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <p class="control has-icons-left">
                        <input id="password_confirmation" type="password" class="input is-small {{ $errors->has('password_confirmation') ? 'is-danger' : '' }}" name="password_confirmation" required placeholder="Confirmar contraseña">
                        <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>

                        @if($errors->has('password_confirmation'))
                            <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                        @endif
                    </p>
                </div>

                <div class="control">
                    <button class="button is-primary is-small is-rounded m-t-10">Restablecer contraseña</button>
                </div>

                <p class="content is-small is-pulled-right m-t-10 m-b-10">
                    <a class="is-muted" href="{{ route('login') }}"><i class="fa fa-fw fa-angle-left"></i> Volver al login</a>
                </p>
            </form>
        </div>
    </div>
</section>

@endsection
