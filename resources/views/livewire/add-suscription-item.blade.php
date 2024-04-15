<div class="cart-page container-fluid">
    <div class="cart-page__wrapper container">
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-3" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                <p class="font-bold">Remember</p>
                <p class="text-sm">Currently, deliveries are only made on Mondays and Tuesdays. 
                    For first-time subscribers, payments are initiated immediately 
                    after you create your subscription. You can select the frequency of delivery 
                    (weekly, every 2 or 3 weeks) when you first create your subscription order. 
                    The “SUSPEND” button allows you to pause a subscription, but it must be done 
                    at least 24hrs before your scheduled payment. Payments are initiated one day 
                    before the delivery date. The “See & Edit” button allows you to modify your 
                    delivery date/frequency. If you want to edit the products in your subscription, 
                    you must create a new order. The “Cancel” button will cancel a subscription indefinitely, 
                    just like the suspend orders must be canceled at least one day prior to the scheduled payment. 
                    Please refer to our FAQ section if you have any more questions.</p>
                </div>
            </div>
        </div>
        <div class="cart-page__box">
            <div class="cart-page__left">
                <div class="cart-page__list">
                    <h3 class="cart-page__title">ORDER</h3>
                    <div>

                        <div  class="item-order">
                            <div class="item-order__left">
                                <div class="item-order__top">
                                    <div class="item-order__box-img">
                                        <img src="{{config('services.trading.url')}}/uploads/img/{{$product->image}}" alt="" class="item-order__img">
                                    </div>
                                    <div class="item-order__box-detail">
                                        <div class="item-order__detail">
                                            <p class="item-order__name">{{$product->name}}</p>
                                            <p class="item-sidebar__extra">
                                                <strong>Description:</strong>
                                                <ul class="item-sidebar__extra__list">
                                                    <li >
                                                        <span>{!! $product->product_description !!}</span>
                                                    </li>
                                                </ul>
                                            </p>
                                            <p class="item-order__price">$ {{ number_format($price,2)}}</p>
                                            @if($product->product_custom_field2 == 1)
                                                <div class="mt-3  flex">
                                                    <span class=" text-brown ">Bread shape: </span>
                                                    <div class="flex items-center mx-2">
                                                        <input id="inline-radio" type="radio" wire:model="bread_shape" value="" name="inline-radio-group" class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 focus:ring-amber-500 " checked>
                                                        <label for="inline-radio" class="ml-2 text-sm font-medium text-gray-900 ">Whole</label>
                                                    </div>
                                                    <div class="flex items-center mx-2">
                                                        <input id="inline-2-radio" type="radio" wire:model="bread_shape" value="Sliced" name="inline-radio-group" class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 focus:ring-amber-500">
                                                        <label for="inline-2-radio" class="ml-2 text-sm font-medium text-gray-900 ">Sliced</label>
                                                    </div>
                                                </div>
                                            @endif 
                                        </div>
                                        <div class="item-order__quanty">
                                            <div class="flex mb-4 mt-3">
                                                <button class="btn"
                                                    {{$qty > 1? '':'disabled'}}
                                                    wire:loading.attr="disabled"
                                                    wire:target="decrement"
                                                    wire:click="decrement">
                                                    <i class="las la-minus"></i>
                                                </button>
                                                <span class="m-3 text-lg"> {{$qty}} </span>
                                                <button class="btn"
                                                    {{$qty >= $quantity? 'disabled':''}}
                                                    wire:loading.attr="disabled"
                                                    wire:target="incrementar"
                                                    wire:click="incrementar"> 
                                                    <i class="las las la-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="cart-page__list">
                    <h3 class="cart-page__title">Customer</h3>
                    <div  class="item-order v-cloak--hidden ">
                        <div class="item-order__left">    
                            <div class="item-order__detail">
                                <p class="mb-2"> <strong>Name:</strong> {{$contact->name}}</p>
                                <p class="mb-2"> <strong>Address:</strong>  {{$contact->address_line_1}} ({{$contact->state}} , {{$contact->city}} , {{$contact->zip_code}})</p>
                                <p class="mb-1"> <strong>Phone:</strong>  {{$contact->mobile}}</p>
                                <p class="text-xs">
                                    <i class="las la-info-circle"></i> If you want to change your address, you can go to "Profile Information" in "My data" 
                                </p>
                                <div class="mt-3" >
                                    <label for="references" class="block text-sm font-medium text-gray-900 ">Note:</label>
                                    <x-jet-input wire:model="references" type="text" placeholder="Note or reference (optional)" class="w-full" />
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cart-page__right">
                <div class="resumen-pedido">
                    <div class="resumen-pedido__header">
                        <h3 class="cart-page__title">SUMMARY</h3>
                    </div>
                    <div class="resumen-pedido__montos" >
                        <p class="resumen-pedido__subtitle ">Subtotal <span>$ {{number_format($price * $qty,2)}}</span></p>
                        <p class="resumen-pedido__subtitle ">Delivery<span class="v-cloak--hidden" >$ {{number_format($shipping,2)}} </span></p>
                        <p class="resumen-pedido__subtitle ">Taxes<span class="v-cloak--hidden" >$ {{number_format($tax_cost,2) }}</span></p>
                        <p class="resumen-pedido__subtitle resumen-pedido__subtitle--total ">Total <span>${{ number_format($total,2) }}</span></p>
                    </div>
                    <div class="resumen-pedido__montos mt-3" >
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 ">Your subscription will start:</label> 
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' class="form-control"  />
                            <span class="input-group-addon">
                                <span class="las la-calendar"></span>
                            </span>
                        </div>
                        <x-jet-input-error for="day" />
                        <x-jet-input-error for="dateSelected" />
                    </div>
                    <div class="resumen-pedido__montos mt-3" >
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 ">Select the frequency:</label>
                        <select  wire:model="frequency" aria-label="frequency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="" disabled >Select on option</option>
                            <option value="7"> Weekly </option>
                            <option value="14">Every 2 weeks</option>
                            <option value="21">Every 3 weeks</option>
                            <option value="28">Every 4 weeks</option>
                        </select>
                        <x-jet-input-error for="frequency" />
                    </div>
                    <div class="resumen-pedido__comments" >
                        <x-jet-button class="resumen-pedido__btn btn btn-red btn-fluid"
                            wire:loading.attr="disabled"
                            wire:target="suscription_product"
                            wire:click="$emit('register')">
                            Confirm suscription
                        </x-jet-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                Livewire.emitTo('add-suscription-item', 'suscription_product');
            });
        </script>
    @endpush
</div>
