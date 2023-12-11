<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])

    {{-- usando fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('links')
    @yield('head-scripts')
</head>

<body>
    <div id="app">
        @include('partials._navbar')
        @if (\Session::has('not_allowed_message'))
            <div class="text-center container py-2">
                <h3>
                    {!! \Session::get('not_allowed_message') !!}
                </h3>
            </div>
        @endif
        @if (\Session::has('payment-error'))
            <div class="text-center container py-2">
                <h3>
                    {!! \Session::get('payment-error') !!}
                </h3>
        @endif

        <main>
            <div class="container">
                
                <div class="nav-btn-container my-3 px-3">
                    @yield('navigation-buttons')
                </div>
            </div>
            @yield('content')
        </main>
    </div>
    @yield('modals')
    @yield('scripts')
</body>

</html>
