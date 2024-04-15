<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Google tag (gtag.js) / google Analytics-->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-KK5V0KVFXM"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-KK5V0KVFXM');
        </script>
        <!-- -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
         <!-- Descriptio, keywork, title -->
        @stack('seo')   
        <meta name="author" content="Onfleek Media S.A.C">
        <!-- META -->
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta property="og:title" itemprop="headline" content="Bread in the box" />
        <meta property="og:description" itemprop="description" content="Bakery Ecomerce" />
        <meta property="og:url" itemprop="url" content="https://breadinthebox.com/" />
        <meta property="og:type" content="Ecommerce" />
        <!-- Google icons-->
        <link rel="icon" type="image/png" sizes="192x192" href="https://breadinthebox.com/images/logo-min-192x192.png">
        <link rel="icon" type="image/png" sizes="96x96" href="https://breadinthebox.com/images/logo-min-96x96.png">
        <link rel="icon" type="image/png" sizes="32x32" href="https://breadinthebox.com/images/logo-min-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="https://breadinthebox.com/images/logo-min-16x16.png">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('style')
        <link rel="stylesheet" href="{{asset('css/line-awesome.css')}}?v=1993.4.1">
        <link rel="stylesheet" href="{{asset('css/app.css')}}?v=1993.4.3">
        <!-- Styles -->
        @livewireStyles
        @stack('css')
    </head>
    <body>
        <div id='main_v'>
            <div>
                <div class="overlay"></div>
            </div>
            <div class="wrapper" id='main'>
                 @livewire('header') 
                <div class="home-loader" >
                    <div data-banner="fixed" >
                    <main>
                        {{$slot}}
                    </main>
                </div>
                @include('footer') 
            </div>
        </div> 
        @stack('modals')
        <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script> 
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @livewireScripts
        @stack('script')
        <!-- JS activa el fondo negro del header al hacer scroll -->
        <script>
            let banner = document.querySelector('[data-banner="fixed"]')
            let fixedBanner = document.querySelector('.fixed-banner')
            let heightFixed;
            let heightBanner = banner.getBoundingClientRect().height;
            window.addEventListener('scroll', function(){
                window.innerWidth >= 1024 ? heightFixed = 100 : heightFixed = 50
                if(window.pageYOffset >= 20){
                    fixedBanner.classList.add('active')
                } else {
                    fixedBanner.classList.remove('active')
                }
            })
        </script>
        <!-- activa el footer version movile -->
        <script src="{{asset('js/animate.js')}}"></script>
    </body>
</html>
