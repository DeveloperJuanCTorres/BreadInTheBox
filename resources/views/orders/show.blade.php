<x-app-layout>
    <div class="fixed-banner "></div> 
    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/shipping-details.webp')}}" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title">Order</h1>
        </div>
    </div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($transaction->shipping_status != 'cancelled')
            <div class="bg-white rounded-lg shadow-lg px-10 py-8 mb-6 flex items-center">
                <div class="relative">
                    <div class="{{ ($transaction->shipping_status == 'ordered' ||  $transaction->shipping_status == 'packed' ||  $transaction->shipping_status == 'shipped' || $transaction->shipping_status == 'delivered' ) ? 'bg-blue-400' : 'bg-gray-400' }}  rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="las la-check text-white"></i>
                    </div>
                    <div class="absolute left-1.5 mt-0.5">
                        <p>Received</p>
                    </div>
                </div>
                <div class="{{ ($transaction->shipping_status == 'packed' ||  $transaction->shipping_status == 'shipped' || $transaction->shipping_status == 'delivered' ) ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2"></div>
                <div class="relative">
                    <div class="{{ ($transaction->shipping_status == 'packed' ||  $transaction->shipping_status == 'shipped' || $transaction->shipping_status == 'delivered' ) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="las la-box text-white"></i>
                    </div>

                    <div class="absolute left-1 mt-0.5">
                        <p>Packed</p>
                    </div>
                </div>
                <div class="{{ ($transaction->shipping_status == 'shipped' || $transaction->shipping_status == 'delivered' ) ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2"></div>
                <div class="relative">
                    <div class="{{ ($transaction->shipping_status == 'shipped' || $transaction->shipping_status == 'delivered' ) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="las la-truck text-white"></i>
                    </div>
                    <div class="absolute left-2 mt-0.5">
                        <p>Sent</p>
                    </div>
                </div>

                <div class="{{ ($transaction->shipping_status == 'delivered' ) ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2"></div>
                <div class="relative">
                    <div class="{{ ($transaction->shipping_status == 'delivered' ) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="las la-box-open text-white"></i>
                    </div>
                    <div class="absolute left-2 mt-0.5">
                        <p>Delivered</p>
                    </div>
                </div>
            </div>
           
            <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6 flex items-center">
                <p class="text-gray-700 uppercase"><span class="font-semibold">N°:</span>
                    Order-{{ $transaction->id }}</p>
                @if ($transaction->status == 'ordered')
                    <x-button-enlace class="ml-auto" href="{{route('orders.payment', $transaction)}}">
                        Go pay <i class="las la-angle-double-right"></i>
                    </x-button-enlace>
                @endif
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-2 gap-6 text-gray-700">
                <div>
                    <p class="text-lg font-semibold uppercase">Address</p>
                    <p class="text-sm">{{$transaction->shipping_address}}</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold uppercase mt-1">The products will be sent to</h2>
                    <p class="text-sm"> <b>Full name:</b> {{ $transaction->delivered_to }} </p>
                    <p class="text-sm"> <b>Phone:</b> {{ $transaction->shipping_custom_field_1 }} </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 text-gray-700 mb-6">
            <p class="text-xl font-semibold mb-4">Summary</p>

            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-start">Price</th>
                        <th class="text-start">quantity</th>
                        <th class="text-start">Subtotal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                @if(empty($item->product))
                                    El producto ya no existe
                                @else
                                <div class="flex">
                                    <img class="h-15 w-20 object-cover mr-4" src="{{config('services.trading.url')}}/uploads/img/{{$item->product->image}}" alt="IMG-PRODUCT">
                                    <article>
                                        <h5 class="font-bold">{{ $item->product->name }}</h5>
                                        @if($item->variation->name !='DUMMY')
                                            <div class="flex text-xs"> {{ $item->variation->name }} </div>
                                        @endif
                                    </article>
                                </div>
                                @endif
                            </td>
                            <td >
                               $ {{ number_format($item->unit_price,2) }}
                            </td>
                            <td class="text-center" >
                                {{ number_format($item->quantity,0) }}
                            </td>
                            <td>
                             $ {{ number_format($item->unit_price * $item->quantity,2) }}
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td class="pt-2">
                            <div class="flex">&nbsp;
                                <b>Total: $ {{number_format($transaction->final_total,2) }} </b> 
                                &nbsp;&nbsp;&nbsp;
                                <span class="text-lime-600"> + Delivery:
                                @if($transaction->shipping_charges == 0)
                                    Free
                                @else
                                    $ {{number_format($transaction->shipping_charges,2) }} 
                                @endif
                                </span>
                                &nbsp;&nbsp;<span class="text-lime-600">+ Taxes: ${{ number_format($transaction->tax_amount,2 ) }}</span>
                            </div>
                        </td>
                        <td class="pt-1"></td>
                        <td class="pt-1"></td>
                        <td class="pt-1"> 
                            $ {{number_format($transaction->total_before_tax,2) }} 
                        </td>
                    </tr>
                </tbody>


            </table>
        </div>
    </div>
    @push('seo')
		<title>Bread in the box | Order</title>
	@endpush
</x-app-layout>