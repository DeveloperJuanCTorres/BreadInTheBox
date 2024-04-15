<x-app-layout>

    <div class="fixed-banner"></div>

    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="https://breadinthebox.com/images/bg-imagen-08.png" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title">MY account</h1>
        </div>
    </div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }} 
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-3 mb-3">
                <div class="md:col-span-1 col-span-3">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900"> Payment method</h3>
                        <p class="mt-1 text-sm text-gray-600">Add a payment method to activate subscriptions.</p>
                    </div>
                </div>
                <div class="md:col-span-2 col-span-3">

                    <div class=" rounded  shadow-lg bg-white p-4">
                        @if(Auth::user()->idPaymentMethod)
                            @foreach( Auth::user()->paymentMethods() as $paymentMethod)
                                <div class="p-4">
                                    <div class="col-md-12">
                                        <strong class="text-green-600"><i class="las la-check"></i> You are enabled to subscribe</strong>
                                    </div>
                                    <div class="col-md-12">
                                        <p> <i class="las la-credit-card"></i> {{$paymentMethod->billing_details->name}} <span class="text-dark mx-3"> / </span> XXXX XXXX XXXX-{{$paymentMethod->card->last4}}</p>
                                        <p>Expires: {{$paymentMethod->card->exp_month}}/{{$paymentMethod->card->exp_year}}</p>
                                    </div>
                                    <button class="btn btn-danger btn-block mt-4 removeCard" data-id="{{$paymentMethod->id}}" >
                                        Remove card
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <p class="mb-4"> <strong class="text-yellow-600"><i class="las la-info"></i> If you do not have a registered payment method you will not be able to subscribe</strong></p>
                            <form id="card-form" class="billing-form mt-3">
                                <div class="form-group mb-3">
                                    <label for="form-label">Card name</label>
                                    <x-jet-input id="card-holder-name" type="text" class=" block w-full" placeholder="Enter the cardholder" required />
                                </div>
                                <div class="form-group">
                                    <label for="form-label ">Card number</label>
                                    <div id="card-element" class="card-number"></div>
                                    <span class="text-danger" id="card-error"></span>
                                </div>
                                <button id="card-button" class="btn btn-red mt-4" data-secret="{{Auth::user()->createSetupIntent()->client_secret}}">
                                    Add payment Method 
                                </button>
                            </form>
                           


                        @endif
                    </div>
                </div>
             </div>  
             
            <x-jet-section-border />

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('update-profile-customer') 
                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>
                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>
            
        </div>
    </div>

    @if(Auth::user()->idPaymentMethod)
       
        @push('script')
            <script>
                $(".removeCard").on('click', function (e) {
                    e.preventDefault();
                    var ele = $(this);
                    var id = ele.attr("data-id");
                    var formData = new FormData(); 

                    Swal.fire({
                        title: 'Are you sure you want to delete your payment method?',
                        text: "your subscriptions will be deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d72626',
                        cancelButtonColor: '#6e7881',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            Swal.fire({
                                header: '...',
                                title: 'loading...',
                                allowOutsideClick:false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                            formData.append('id',id);

                            $.ajax({
                                type: "post",
                                url: "/remove-card",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    if(response.status){
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'removed',
                                            text: response.msg,
                                        }).then((result) => {
                                            location.reload();
                                        });
                                    }
                                    else{
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...!!',
                                            text: 'An error occurred, please try again later!',
                                        })
                                    }
                                },
                                error: function () {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...!!',
                                        text: 'An error occurred, please try again later!',
                                    })
                                },
                            });
                        }
                    })
                });
            </script>
        @endpush

    @else

        @push('script')
            <script src="https://js.stripe.com/v3/"></script> 
            <script>
                const stripe = Stripe("{{ config('services.stripe.key') }}");
                const elements = stripe.elements();
                const cardElement = elements.create('card');
                cardElement.mount('#card-element');
                const cardHolderName = document.getElementById('card-holder-name');
                const cardButton = document.getElementById('card-button');
                const cardForm = document.getElementById('card-form');
                const clientSecret = cardButton.dataset.secret;
            
                cardForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const { setupIntent, error } = await stripe.confirmCardSetup(
                        clientSecret, {
                            payment_method: {
                                card: cardElement,
                                billing_details: { name: cardHolderName.value }
                            }
                        }
                    );
                    if (error) {
                        document.getElementById('card-error').textContent = error.message;
                    } else {

                        Swal.fire({
                                header: '...',
                                title: 'Loading...',
                                allowOutsideClick:false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                        });

                        $.ajax({
                        url: "/register-card",
                        method: "post",
                        dataType: 'json',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            setupIntent: setupIntent.payment_method,
                        },

                        success: function (response) {
                            if(response.status){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated',
                                    text: 'card registered successfully',
                                    allowOutsideClick: false,
                                    confirmButtonText: "Ok",
                                })
                                .then(resultado => {
                                    window.location.reload();
                                })
                            }else{
                                Swal.fire({
                                icon: 'error',
                                title: 'Oops...!!',
                                text: 'An error occurred, please try again later!',
                                })
                            }		
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...!!',
                                text: 'An error occurred, please try again later!',
                                })
                        }
                    });
                    }
                });
            </script>
        @endpush

    @endif
    
</x-app-layout>
