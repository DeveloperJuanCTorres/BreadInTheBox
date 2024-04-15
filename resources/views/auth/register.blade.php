<x-app-layout>

    <div class="fixed-banner"></div>

    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/contact-us.webp')}}" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title">MY ACCOUNT</h1> 
        </div>
    </div>

    <div class="login-wrap">
        <div class="login container">
            <div class="login__login">
                <div class="login__box-title">
                    <p class="login__title">Register</p>
                </div>

                <x-slot name="logo"></x-slot>
                <x-jet-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-2">
                        <x-jet-label for="type_user" value="Type of user" />
                        <ul class="items-center w-full text-sm font-medium  border border-gray-200 rounded-lg sm:flex mt-1">
                            <li class="w-full">
                                <div class="flex items-center pl-3">
                                    <input id="horizontal-list-radio-license" type="radio" value="person" name="list-radio" class="w-4 h-4 text-blue-600 " checked>
                                    <label for="horizontal-list-radio-license" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 ">Person</label>
                                </div>
                            </li>
                            <li class="w-full">
                                <div class="flex items-center pl-3">
                                    <input id="horizontal-list-radio-id" type="radio" value="busines" name="list-radio" class="w-4 h-4 text-blue-600">
                                    <label for="horizontal-list-radio-id" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 ">Business</label>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Persona Natural -->
                    <div id="person">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <x-jet-label for="first_name" value="Name" />
                                <x-jet-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')"   autofocus autocomplete="first_name" />
                            </div>
                            <div >
                                <x-jet-label for="last_name" value="Last name" />
                                <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"   autofocus autocomplete="last_name" />
                            </div>
                        </div>
                    </div>
                    <!-- Empresa -->
                    <div id="busines">
                        <div >
                            <x-jet-label for="busines" value="Business name" />
                            <x-jet-input id="busines" class="block mt-1 w-full" type="text" name="busines" :value="old('busines')"   autofocus autocomplete="busines" />
                        </div>
                    </div> 
                    <!---------------------->
                    <div class="mt-4">
                        <x-jet-label for="zip" value="Zip code" />
                        <select name="zip" id="zip" class="block mt-1 w-full">
                            <option value="" selected disabled>Select an option</option>
                            <option value="80104">80104 - Castle Rock</option>
                            <option value="80108 ">80108 -Castle Rock</option>
                            <option value="80109">80109 -Castle Rock</option>
                        </select>
                      
                    </div> 
                    <div class="mt-4">
                        <x-jet-label for="address" value="Address" />
                        <x-jet-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"  autofocus autocomplete="address" required />
                    </div> 

                    <div class="mt-4">
                        <x-jet-label for="mobile" value="Phone" />
                        <x-jet-input id="mobile" class="block mt-1 w-full" type="number" name="mobile" :value="old('mobile')" required /> 
                    </div>
                   
                    <div class="mt-4">
                        <x-jet-label for="email" value="Email" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password" value="Password" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password_confirmation" value="Confirm Password" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-jet-label for="terms">
                                <div class="flex items-center">
                                    <x-jet-checkbox name="terms" id="terms" required />

                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-jet-label>
                        </div>
                    @endif

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            Are you already registered?
                        </a>
                        <x-jet-button class="ml-4 btn btn-red btnIngresar">
                            Registrar
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('script')
    <script type="text/javascript">
        /*funcion Boleta/Factura*/
        $(document).ready(function() {
            $('#person').show();
            $('#busines').hide();
        })
        $('input[name="list-radio"]').click(function() {
            if ($(this).attr("value") == "person") {
                $("#person").show();
                $("#busines").hide();
            }
            if ($(this).attr("value") == "busines") {
                $("#person").hide();
                $("#busines").show();
            }
        });
    </script>
    @endpush

</x-app-layout>
