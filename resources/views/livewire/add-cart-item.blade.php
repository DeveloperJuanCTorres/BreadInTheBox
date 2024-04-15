<div x-data>
    <div class="month__products">
        <div class="container">
            <div class="row ">
                <div class="flex flex-col items-center  border-gray-200 rounded-lg shadow md:flex-row bg-stone-200">
                    <img class="object-cover w-full rounded-t-lg  md:h-auto md:w-1/3 md:rounded-none md:rounded-s-lg" src="{{config('services.trading.url')}}/uploads/{{$image}}" alt="">
                    <div class="flex flex-col justify-between p-4 leading-normal bg-white">
                        <h2 class="text-3xl  tracking-tight">{{$product->name}}</h2>
                        <p class="text-2xl  text-brown "><strong> ${{ number_format($product->variation->first()->sell_price_inc_tax,2)}}</strong></p>
                        <p class="mb-5 font-normal text-gray-700  text-2xl"> {!! $product->product_description !!}</p>
                        
                            @if($product->product_custom_field2 == 1)
                                <div class="my-4  flex">
                                    <span class=" text-brown  text-xl">Bread shape: </span>
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

                           
                            <div class="flex mb-4 mt-3 ml-2">
                                <button class="btn btn-brown-line"
                                    {{$qty > 1? '':'disabled'}}
                                    wire:loading.attr="disabled"
                                    wire:target="decrement"
                                    wire:click="decrement">
                                    <i class="las la-minus"></i>
                                </button>
                                <span class="m-3 text-lg"> {{$qty}} </span>
                                <button class="btn btn-brown-line"
                                    {{$qty >= $quantity? 'disabled':''}}
                                    wire:loading.attr="disabled"
                                    wire:target="incrementar"
                                    wire:click="incrementar"> 
                                    <i class="las las la-plus"></i>
                                </button>
                            </div>
                            <div class="mt-3">
                                <a class="btn btn-brown-line ml-2"
                                    {{$qty > $quantity? 'disabled':''}}
                                    wire:click="$emit('addItemcart')"
                                    wire:loading.attr="disabled"
                                    wire:target="addItem">
                                    <i class="las la-shopping-bag mr-1"></i>  Add Product
                                </a>
                                <a class="btn btn-black-line" href="{{route('suscription.create',$product)}}">  <i class="las la-bell mr-1"></i> Subscribe</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    @push('script')
        <script>
           Livewire.on('addItemcart', () => {
                Livewire.emitTo('add-cart-item', 'addItem');
                
                const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                 }
                });
                Toast.fire({
                    icon: "success",
                    title: "The product is added to the cart",
                });
            })
        </script>
    @endpush
</div>
