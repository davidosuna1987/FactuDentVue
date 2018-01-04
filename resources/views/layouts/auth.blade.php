<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FactuDent @yield('title')</title>

    {{-- Styles --}}
    @include('partials.styles')
    @stack('styles')
</head>
<body>
    <div id="app" class="auth">
        @include('partials.navbar.main')
        <main>
            <div class="content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    @include('partials.scripts')
    @stack('scripts')
</body>
</html>
