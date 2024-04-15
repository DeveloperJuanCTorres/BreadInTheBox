<div>
    <div class="fixed-banner"></div>
    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/payment.webp')}}" alt="questions" class="banner-category__img fr-fic fr-dii">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title">Payment method</h1>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 gap-6 container py-8">
        <div class="order-2 lg:order-1 xl:col-span-3">
            
            <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
                <p class="text-gray-700 uppercase"><span class="font-semibold"># ORDER:</span> Orden-{{ $transaction->id }}</p>
                <input type="hidden" id="idorder" value="{{$transaction->id}}" >
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="grid grid-cols-2 gap-6 text-gray-700">
                    <div>
                        <p class="text-lg font-semibold uppercase">Shipment</p>
                        <b class="text-sm">The products will be sent to:</b>
                        <p class="text-sm">{{$transaction->shipping_address}}</p>
                    </div>
                    <div>
                        
                        <p class="text-lg font-semibold uppercase mt-1">Person who will receive the order</p>
                        <p class="text-sm"> <b>Full name:</b> {{ $transaction->delivered_to }} </p>
                        <p class="text-sm"> <b>Phone:</b> {{ $transaction->shipping_custom_field_1 }} </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 text-gray-700 mb-6">
                <p class="text-xl font-semibold mb-4">Summary</p>
                <x-table-responsive>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="px-2"> Price</th>
                            <th class="px-2"> Quantity </th>
                            <th class="px-2"> Total </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($items as $item)
                            <tr>
                                <td class="pt-2">
                                    <div class="flex">
                                        <img class="h-15 w-20 object-cover mr-4" src="{{config('services.trading.url')}}/uploads/img/{{$item->product->image}}" alt="IMG-PRODUCT">
                                        <article style="min-width: 200px;">
                                            <h5>{{$item->product->name }}</h5>
                                            @if($item->variation->name !='DUMMY')
                                                <div class="flex text-xs"> {{ $item->variation->name }} </div>
                                            @endif
                                        </article>
                                    </div>
                                </td>

                                <td class="text-center px-2 pt-2">
                                    $ {{ number_format($item->unit_price,2) }}
                                </td>

                                <td class="text-center px-2 pt-2">
                                    {{ number_format($item->quantity,0) }}
                                </td>

                                <td class="text-center px-2 pt-2">
                                    $ {{ number_format($item->unit_price * $item->quantity,2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="p-2">
                                <div class="flex">&nbsp;
                                    <strong>Total: </strong> $ {{number_format($transaction->total_before_tax,2) }}
                                    <strong class="mx-2">Delivery: </strong>
                                    @if($transaction->shipping_charges == 0)
                                        Free
                                    @else
                                        $ {{number_format($transaction->shipping_charges,2) }} 
                                    @endif
                                    <strong class="mx-2">Taxes: </strong>
                                    {{ number_format($transaction->tax_amount,2 ) }}
                                </div>
                                
                               
                            </td>
                           
                            <td class="p-2"></td>
                            <td class="p-2"></td>
                            <td class="p-2 text-center"> 
                                <strong>  $ {{number_format($transaction->final_total,2) }}  </strong>
                            </td>
                        </td>
                    </tbody>
                </table>
            </x-table-responsive>
            </div>
        </div>

        <div class="order-1 lg:order-2 xl:col-span-2">
            <div class="bg-white rounded-lg shadow-lg px-6 pt-6">
                <div class="flex justify-between items-center mb-3">
                    <img class="h-8" src="{{ asset('/images/MC_VI_DI_2-1.png') }}" alt="">
                    <div class="text-gray-700 pl-2 text-right">
                        @if($transaction->shipping_charges <> 0)
                            <p class="text-sm font-semibold">
                                Subtotal: $ {{number_format($transaction->total_before_tax,2) }}
                            </p>
                            <p class="text-sm font-semibold">
                                Delivery: $ {{number_format($transaction->shipping_charges,2) }} 
                            </p>
                            <p class="text-sm font-semibold">
                                Taxes: $ {{number_format($transaction->tax_amount,2) }} 
                            </p>
                        @endif
                        <p class="text-xl font-semibold uppercase">
                            Total: ${{number_format($transaction->final_total,2) }} 
                        </p>
                    </div>
                </div>
                <div class="pb-4">
                    <div class="focus-form">

                        <div class="row align-items-center mb-3">
                            <div class="col">
                            <h2 class="text-2xl font-bold  text-center">  Payment method </h2>
                                <p class="text-3xl text-center">  <i class="lab la-cc-discover"></i> <i class="lab la-cc-jcb"></i> <i class="lab la-cc-visa"></i> <i class="lab la-cc-mastercard"></i></p>
                            </div>
                        </div>  
                        <form id="card-form">
                            <div class="focus-form__group">
                                <label for="form-label">Card name</label>
                                <div>
                                    <input  id="card-holder-name" type="text" placeholder="Enter the cardholder" required>
                                </div>
                            </div>
                            <div class="focus-form__group mt-3">
                                <label for="form-label ">Card number</label>
                                <div class="card-number">
                                    <div id="card-element"></div>
                                    <span class="text-danger" id="card-error"></span>
                                </div>
                            </div>
                            <button id="card-button" class="btn btn-red btn-fluid">
                                 Place order 
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

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
        
        cardForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', cardElement, {
                    billing_details: { name: cardHolderName.value }
                }
            );
        
            if (error) {
                // Display "error.message" to the user...
                document.getElementById('card-error').textContent = error.message;
            } else {
                // The card has been verified successfully...
                var idorder = $('#idorder').val();
                $.ajax({
                    url: "/topay",
                    method: "post",
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        paymentMethod: paymentMethod.id,
                        idorder: idorder,
                        
                    },
                    beforeSend: function () {
                        Swal.fire({
                            header: '...',
                            title: "Loading...",
                            allowOutsideClick:false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: function (response) {
                        if(response.status){
                            Swal.fire({
                                icon: 'success',
                                title: "Thanks for your purchase",
                                text: response.msg,
                                allowOutsideClick: false,
                                confirmButtonText: "OK",
                            })
                            .then(resultado => {
                                window.location.href = "/orders-thanks/"+idorder
                            })
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: "ERROR",
                                text: response.msg,
                            })
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: "Upss!!",
                            text: "Something went wrong!",
                        })
                    }
                });
            }
        });

    </script>
    @endpush

    @push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
        <meta property="og:image" itemprop="image" content="{{$seo['image']}}" />
	@endpush
</div>