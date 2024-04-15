<x-app-layout>
    <div class="fixed-banner"></div>

    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/contact-us.webp')}}" alt="contact-us" class="banner-category__img">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title">MY ACCOUNT</h1> 
        </div>
    </div>

    <div class="login-wrap">
        <div class="login container">
            <div class="login__login">
                
                <x-slot name="logo"></x-slot>
                <div class="mb-4 text-sm text-gray-600">
                    Did you forget your password? No problem. Simply let us know your email address and we'll send you a password reset link that will allow you to choose a new one.
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <x-jet-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="block">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-jet-button> Send link </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
