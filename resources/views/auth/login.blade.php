@extends('layouts.app')

@section('content')

<section class="guest-form">
    <div class="background" style="background-image: url({{ asset('images/backgrounds/gabinete-herramientas.jpg')  }});"></div>
    <div class="form-container">
        <form class="form" method="POST" action="{{ route('login') }}" role="form">
            {{ csrf_field() }}

            <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="label is-small">E-Mail</label>

                <p class="control has-icons-left">
                    <input id="email" type="email" class="input is-small{{ $errors->has('email') ? ' is-danger' : ' is-primary' }}" name="email" value="{{ old('email') }}" required autofocus>
                    <span class="icon is-small is-left"><i class="fa fa-at"></i></span>

                    @if($errors->has('email'))
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @endif
                </p>
            </div>

            <div class="field{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="label is-small">Contraseña</label>

                <p class="control has-icons-left">
                    <input id="password" type="password" class="input is-small{{ $errors->has('password') ? ' is-danger' : ' is-primary' }}" name="password" required>
                    <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>

                    @if($errors->has('password'))
                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                    @endif
                </p>
            </div>

            <b-checkbox name="remember" class="label is-small">Recuérdame</b-checkbox>

            <div class="control">
                <button class="button is-primary is-small is-outlined m-t-10">Entrar</button>
            </div>

            <p class="content is-small is-pulled-right">
                <a class="is-muted" href="{{ route('password.request') }}">¿Olvidaste la contraseña?</a>
            </p>
        </form>
    </div>
</section>

@endsection
