@extends('layouts.auth')

@section('content')

<section class="guest-form">
    <div class="background" style="background-image: url({{ asset('images/backgrounds/gabinete-herramientas.jpg')  }});"></div>
    <div class="form-container">
        @if (session('status'))
            <div class="notification is-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="form" method="POST" action="{{ route('password.email') }}" role="form">
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

            <div class="control">
                <button class="button is-primary is-small is-outlined m-t-10">Enviar correo de recuperación</button>
            </div>

            <p class="content is-small is-pulled-right m-t-10">
                <a class="is-muted" href="{{ route('login') }}"><i class="fa fa-fw fa-angle-left"></i> Volver al login</a>
            </p>
        </form>
    </div>
</section>

@endsection
