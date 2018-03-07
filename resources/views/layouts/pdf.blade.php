<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <title>FactuDent @yield('title')</title>
    @stack('styles')
</head>
<body>
    <div id="app" class="pdf">
        @if(auth()->user()->show_logo)
            <img class="pdf-logo" src="{{auth()->user()->customLogoFilePath() ? auth()->user()->customLogoFilePath() : asset('images/factudent-logo.png')}}" width="112">
        @endif

        <main class="container">
            <div class="content">
                @yield('content')
            </div>
        </main>
    </div>

    <footer>
        @if(auth()->user()->show_advertising)
            <p class="factudent-advertising">Esta factura ha sido generada a través de la aplicación de facturas FactuDent.</p>
        @endif
    </footer>
</body>
</html>
