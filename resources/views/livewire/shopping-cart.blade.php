<div>

    <div class="fixed-banner "></div> 

    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/shopping-cart.webp')}}" alt="" class="banner-category__img fr-fic fr-dii">
        <div class="banner-category__box-title">
        <h1 class="banner-category__title">Shopping cart</h1>
        </div>
    </div>

    <div class="container py-5">

        @if (Cart::getContent()->count())
            <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-700">
                            <span class="font-bold text-lg ">Options</span>
                        </p>
                    </div>
                    <div>
                        <a href="{{route('suscription.cart')}}" class="btn btn-brown-line mr-3">
                            <i class="las la-bell"></i> Subscribe cart 
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <x-table-responsive>
            @if (count(Cart::getContent()) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="pl-5 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                 Delete
                            </th>

                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Sub total
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach (Cart::getContent() as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                            
                                    <div class="ml-5">
                                        <a href="javascript:void(0);" class="text-secondary"
                                            wire:click="delete('{{$item->id}}')"
                                            wire:loading.class="text-red-600 opacity-25"
                                            wire:target="delete('{{$item->id}}')">
                                            <i class="las la-times text-xl"></i>
                                        </a>
                                    </td>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-20 w-20">
                                            <img src="{{config('services.trading.url')}}/uploads/{{$item->attributes->image}}" alt="IMG-PRODUCT"> 	  
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($item->name,85)}}
                                            </div>
                                            @if($item->attributes->variante != 'DUMMY')
                                                <div class="text-sm text-gray-700"> 
                                                    @if($item->attributes->variante > 1)
                                                        <i class="las la-boxes"></i>   Package of {{ $item->attributes->variante}} unit
                                                    @else
                                                        <i class="las la-certificate"></i>   Special of the month 
                                                    @endif
                                                </div>
                                            @endif
                                            @if($item->attributes->bread_shape == 'Sliced')
                                                <div class="text-sm text-gray-700">
                                                    <i class="las la-bread-slice"></i> Sliced ​​bread
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">
                                        <span>  $ {{number_format($item->price,2) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">
                                        @livewire('update-cart-item', ['rowId' => $item->id], key($item->id)) 
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="text-sm text-gray-700">
                                        $ {{number_format(Cart::get($item->id)->getPriceSum(),2) }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-4 bg-stone-100">
                    <button class="btn mr-3" wire:click="destroy">
                        <i class="las la-trash text-xl"></i> Clean the shopping cart
                    </button>
                </div>

            @else
                <div class="flex flex-col items-center bg-white">
                    <p class="text-lg text-gray-700 mt-4">Your cart is empty</p>
                    <a href="{{route('home')}}" class="my-4  size-102"> <i class="las la-home"></i> Go to home</a>
                </div>
            @endif
        </x-table-responsive>
    
        @if (Cart::getContent()->count())
            <div class="bg-white rounded-lg shadow-lg px-6 py-4 mt-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-700">
                            <span class="font-bold text-lg ">Total:</span>
                            $ {{number_format(Cart::getSubTotal(),2)}}
                        </p>
                    </div>
                    <div>
                        <a href="{{route('orders.create')}}" class=" btn btn-red">
                            Proccees to checkout<i class="las la-angle-double-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
        <meta property="og:image" itemprop="image" content="{{$seo['image']}}" />
	@endpush

</div>
