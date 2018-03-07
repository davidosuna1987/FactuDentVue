@extends('layouts.auth')

@section('content')

<section class="guest-form floating-tooth-background">
    <h1 class="auth-title has-text-centered">Recuperar contraseña</h1>
    <div class="card">
        <div class="card-content">
            @if (session('status'))
                <div class="notification is-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form" method="POST" action="{{ route('password.email') }}" role="form">
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

                <div class="control">
                    <button class="button is-primary is-small is-rounded m-t-10">Enviar correo de recuperación</button>
                </div>

                <p class="content is-small is-pulled-right m-t-10 m-b-10">
                    <a class="is-muted" href="{{ route('login') }}"><i class="fa fa-fw fa-angle-left"></i> Volver al login</a>
                </p>
            </form>
        </div>
    </div>
</section>

@endsection
