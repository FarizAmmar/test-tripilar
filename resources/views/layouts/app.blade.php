<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('src/img/icons/icon-48x48.png') }}" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>{{ env('APP_NAME') }}</title>

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    {{-- Styles CSS --}}
    @include('layouts.partials.css.style')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{-- Main Wrapper --}}
    <div class="wrapper">
        {{-- Sidebar --}}
        @auth
            @include('layouts.auth.sidebar')
        @endauth

        <div class="main">
            {{-- Navbar --}}
            @auth
                @include('layouts.auth.navbar')
            @endauth

            {{-- Main Content --}}

            {{-- Untuk yang sudah login / authenticated --}}
            @auth
                <main class="content">
                    <div class="container-fluid p-0">

                        @yield('main-content')

                    </div>
                </main>
            @endauth

            {{-- Untuk yang belum login / authenticated --}}
            @guest
                <main class="d-flex w-100">
                    <div class="d-flex flex-column container">
                        @yield('main-content')
                    </div>
                </main>
            @endguest

            {{-- Footer --}}
            @auth
                @include('layouts.auth.footer')
            @endauth
        </div>
    </div>

    {{-- Javascripts --}}
    @include('layouts.partials.js.script')
    @stack('scripts')
</body>

</html>
