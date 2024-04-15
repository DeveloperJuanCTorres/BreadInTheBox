<x-app-layout>

    <div class="fixed-banner"></div>

    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/contact-us.webp')}}" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
           <h1 class="banner-category__title">My account</h1> 
        </div>
    </div>

    <div class="login-wrap">
        <div class="login container">
            <div class="login__login">
                
                <div class="login__box-title">
                    <p class="login__title">Login</p>
                </div>
                <div class="login__desc"><p>If you have purchased from "Bread in the Box" before, just enter your email and password to access your account.</p></div>
                <div class="login__subtitle">Don't have an account yet? <a href="{{route('register')}}">sign up here</a> </div>
                <x-jet-validation-errors class="mb-1"/>
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST"  class="form" action="{{ route('login') }}">
                    @csrf
                    <div class="mt-3">
                        <x-jet-label for="email" value="Email" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    </div>
                    <div class="mt-4">
                        <x-jet-label for="password" value="Password" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>
                    <div class="flex items-center justify-center mt-4">
                        <x-jet-button class="btn btn-red btnIngresar">
                            <span class="px-5">Login</span> 
                        </x-jet-button>
                    </div>
                    <hr class="mt-3">
                    <div class="flex items-center justify-center mt-2 ">
                        @if (Route::has('password.request'))
                            <a  class="underline text-sm title-atlifor-m" href="{{ route('password.request') }}">
                                Did you forget your password?
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</x-app-layout>
