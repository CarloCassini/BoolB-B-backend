<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

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

        <main class="">
            @yield('navigation-buttons')
            @yield('content')
        </main>
    </div>
    @yield('modals')
    @yield('scripts')
</body>

</html>
