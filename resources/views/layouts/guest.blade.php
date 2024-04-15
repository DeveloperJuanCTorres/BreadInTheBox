<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Libra international - Login</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
        <!-- Scripts -->
        <!-- vite(['resources/css/app.css', 'resources/js/app.js']) -->
        <link rel="stylesheet" href="{{asset('css/line-awesome.css')}}?v=1993.1.1">
        <link rel="stylesheet" href="{{asset('css/app.css')}}?v=1993.1.2">
        <link rel="icon" type="image/png" href="/images/logo-min.png"/>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    
        <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
        @stack('script')
    </body>
</html>
