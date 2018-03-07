@extends('layouts.auth')

@section('content')

<section class="guest-form floating-tooth-background">
    <h1 class="auth-title has-text-centered">Login</h1>
    <div class="card">
        <div class="card-content">
            <form class="form" method="POST" action="{{ route('login') }}" role="form">
                {{ csrf_field() }}

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

                <b-checkbox name="remember" size="is-small" class="label is-small">Recuérdame</b-checkbox>

                <div class="control">
                    <button class="button is-primary is-small is-rounded m-t-10">Entrar</button>
                </div>

                <p class="content is-small is-pulled-right m-t-10 m-b-10">
                    <a class="is-muted" href="{{ route('password.request') }}">¿Olvidaste la contraseña?</a>
                </p>
            </form>
        </div>
    </div>
</section>

@endsection
