
<div>
    <div class="fixed-banner "></div> 
    
    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/shipping-details.webp')}}" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title">Checkout</h1>
        </div>
    </div>

        <div class="container py-8 grid lg:grid-cols-2 xl:grid-cols-5 gap-6">
            <div class="order-2 lg:order-1 lg:col-span-1 xl:col-span-3">
                @if (Cart::getContent()->count())
                    <div class="bg-white rounded-lg shadow p-6">
                        <label class=" flex items-center cursor-pointer">
                            <p class="mb-2 text-lg text-gray-700 font-semibold">Customer</p>
                        </label>
    
                        <div class="items-center mb-2">
                            <x-jet-label value="Full name" />
                            <x-jet-input type="text" value="{{Auth::user()->first_name}} {{Auth::user()->last_name}}"  class="w-full bg-gray-300"  disabled/>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-2">
                            <div>
                                <x-jet-label value="Phone" />
                                <x-jet-input type="number" value="{{$contact->mobile}}"  class="w-full bg-gray-300"  disabled/>
                            </div>
                            <div>
                                <x-jet-label value="Email" />
                                <x-jet-input type="text" value="{{Auth::user()->email}}" class="w-full bg-gray-300"  disabled/>
                            </div>
                        </div>
                        <p class="mt-4 text-sm">
                            <i class="las la-info-circle"></i> The account holder is the default contact. If you wish to edit this information, go to "Profile Information" in your user account.
                        </p>
                    </div>
                    <!-- inicio -->
                    <div>
                        <p class="mt-6 mb-3 text-lg text-gray-700 font-semibold">Delivery date</p>
                        <div class="bg-white rounded-lg shadow px-6 py-4 grid grid-cols-1 lg:grid-cols-2">
                            <div class=" mt-3" >
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 ">Select the delivery date (Monday or Tuesday):</label> 
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control"  />
                                    <span class="input-group-addon">
                                        <span class="las la-calendar"></span>
                                    </span>
                                </div>
                                <x-jet-input-error for="day" />
                                <x-jet-input-error for="dateSelected" />
                            </div>
                        </div>

                        <p class="mt-6 mb-3 text-lg text-gray-700 font-semibold">Send</p>
                        <label class="bg-white rounded-lg shadow px-6 py-4 flex items-center mb-4 cursor-pointer">
                            <input wire:model="envio_type" type="radio" value="1" name="envio_type" class="text-blue-600" {{$envio_type == 1 ? 'checked' : ''}} > 
                            <span class="ml-3 text-gray-700">
                                <b>Address:</b> {{$contact->state}}, {{$contact->city}},  {{$contact->address_line_1}}
                            </span>
                        </label>

                        <div class="bg-white rounded-lg shadow">
                            <label class="px-6 py-4 flex items-center cursor-pointer">
                                <input wire:model="envio_type"  type="radio" value="2" name="envio_type" class="text-blue-600" {{$envio_type == 2 ? 'checked' : ''}}>
                                <b class="ml-3 text-gray-700">
                                    Send to another address
                                </b>
                            </label>
                            <div class="px-6 pb-6 grid grid-cols-2 gap-6  {{$envio_type == 2 ? '' : 'hidden'}}" >
                                <div>
                                    <x-jet-label value="Zip code" />
                                    <select class="form-control w-full" wire:model="zip_code">
                                        <option value="" selected disabled>Select an option</option>
                                        <option value="80104">80104 - Castle Rock</option>
                                        <option value="80108">80108 - Castle Rock</option>
                                        <option value="80109">80109 - Castle Rock</option>
                                    </select>
                                    <x-jet-input-error for="zip_code" />
                                </div>
                                <div>
                                    <x-jet-label value="Address" />
                                    <x-jet-input class="w-full" wire:model="address" type="text" />
                                    <x-jet-input-error for="address" />
                                </div>
                            </div>
                        </div> 

                        <p class="mt-6 text-lg text-gray-700 font-semibold">Reference</p>
                        <div class="col-span-2">
                            <x-jet-label value="" />
                            <x-jet-input class="w-full" wire:model="references" type="text" placeholder="Note or reference (optional)" />
                            <x-jet-input-error for="references" />
                        </div>

                        <div class="p-1 mt-2" >
                            <div class="flex items-center">
                                <input  wire:model="isActive" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                <label for="link-checkbox" class="ml-2 text-lg font-medium text-gray-900 "> 
                                    I agree with the  <a href="{{Route('conditions')}}" target="_blank" class="font-semibold">terms and conditions</a></label>
                            </div>
                            <p class="text-red-600">
                                @if(!$isActive)
                                    You have to accept the terms and conditions to continue
                                @endif
                                <x-jet-input-error for="terminos" />
                            </p>
                        </div>
                    </div>
                    <!-- fin -->
                @else
                    <div class="items-center">
                        <b class="text-lg text-gray-700 mt-4">Your cart is emty</b>
                    </div>
                @endif
                <div class="mt-3">
                    @if (Cart::getContent()->count())
                        <div class="text-center">
                            <x-jet-button class="btn btn-red mb-3"
                                wire:loading.attr="disabled"
                                wire:target="create_order"
                                wire:click="$emit('register')">
                                Confirm purchase
                            </x-jet-button>
                        </div>
                    @else
                        <div class="text-center">
                            <a href="/" class="btn btn-primary bor1 size-102 bg-purpura  mb-3"> Go home </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="order-1 lg:order-2 lg:col-span-1 xl:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <ul>
                        @forelse (Cart::getContent() as $item)
                            <li class="flex p-2 border-b border-gray-200">
                                <img class="h-20 w-20 object-cover mr-4" src="{{config('services.trading.url')}}/uploads/{{$item->attributes->image}}" alt="">
                                <article class="flex-1">
                                    <h5 class=" ">
                                        {{$item->name}}
                                    </h5>
                                    <div class="flex">
                                        <p>Cant: {{$item->quantity}}</p>
                                    </div>
                                    <p>$ {{ number_format($item->price,2)}}</p>
                                </article>
                            </li>
                        @empty
                            <li class="py-6 px-4">
                                <p class="text-center text-gray-700">
                                    You have no items added to your cart
                                </p>
                            </li>
                        @endforelse
                    </ul>

                    <div class="text-gray-700 mt-4">
                        <p class="flex justify-between items-center mb-2">
                            Subtotal
                            <span class="font-semibold">  $ {{  number_format(Cart::getSubTotal(),2)}}</span>
                        </p> 
                        <p class="flex justify-between items-center mb-2">
                            Tax
                            <span class="font-semibold">  $ {{  number_format( $tax_cost ,2)}}</span>
                        </p> 
                        @if($shipping_cost)
                        <p class="flex justify-between items-center">
                            Delivery
                            <span class="font-semibold">  $ {{  number_format( $shipping_cost ,2)}}</span>
                        </p> 
                        @endif
                        <hr class="my-2">
                        <p class="mt-3 flex justify-between items-center font-semibold">
                            <span class="text-2xl ">Total</span>
                            <span class="text-xl">
                                $ {{number_format((Cart::getSubTotal() + $shipping_cost + $tax_cost),2)}}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    @push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
        <meta property="og:image" itemprop="image" content="{{$seo['image']}}" />
	@endpush


    @push('style')
        <link rel="stylesheet" href="{{asset('css/style-calendar.css')}}">
        <link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    @endpush

    @push('script')
        <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datepicker({
                    format: "mm/dd/yy",
                    weekStart: 0,
                    calendarWeeks: true,
                    autoclose: true,
                    todayHighlight: true, 
                    orientation: "auto",
                });
            }); 

            $("#datetimepicker1").datepicker().on('changeDate',function(e){
                dia = new Date(e.date).getDay();
                const dias = ['sunday','monday','Tuesday','wednesday','thursday','friday','saturday',];
                if ( dia != 1 && dia != 2) {
                    Swal.fire({
                        icon:'warning',
                        text: 'Delivery days are only Mondays and Tuesdays.',
                    });
                }else{
                    Swal.fire({
                        title:'Deadline',
                        icon:'info',
                        text: 'You will receive your order every '+ dias[dia] +' ',
                    });
                }
            });
        </script>

        <script>
            livewire.on('register',()=>{
                let timerInterval;
                    Swal.fire({
                    title: "Loading...",
                    timer: 2500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                    }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log("I was closed by the timer");
                    }
                });


                @this.day = new Date($('#datetimepicker1').datepicker('getDate')).getDay();
                @this.startDay = $('#datetimepicker1').datepicker('getDate');
                Livewire.emitTo('create-order', 'create_order');
            });
        </script>
    @endpush


</div>