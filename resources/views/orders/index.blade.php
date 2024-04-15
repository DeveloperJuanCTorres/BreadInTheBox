<x-app-layout>
    <div class="fixed-banner "></div> 
    
    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="https://breadinthebox.com/images/bg-imagen-08.png" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title"> My orders </h1>
        </div>
    </div>

    <div class="container py-12">
        <section class="grid lg:grid-cols-6 gap-6 text-white">
            <a href="{{ route('orders.index') . "?status=Earring" }}" class="bg-gray-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4 status-link" >
                <p class="text-center text-2xl">
                    {{$pendiente}}
                </p>
                <p class="uppercase text-center">In progress</p>
                <p class="text-center text-2xl mt-2">
                    <i class="las la-clock"></i>
                </p>
            </a>

            <a href="{{ route('orders.index') . "?status=ordered" }}" class="bg-blue-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4 status-link">
                <p class="text-center text-2xl">
                    {{$recibido}}
                </p>
                <p class="uppercase text-center">Received</p>
                <p class="text-center text-2xl mt-2">
                    <i class="las la-check"></i>
                </p>
            </a>

            <a href="{{ route('orders.index') . "?status=packed" }}" class="bg-yellow-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4 status-link">
                <p class="text-center text-2xl">
                    {{$enviado}}
                </p>
                <p class="uppercase text-center">Packed</p>
                <p class="text-center text-2xl mt-2">
                    <i class="las la-box"></i>
                </p>
            </a>

            <a href="{{ route('orders.index') . "?status=shipped" }}" class="bg-pink-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4 status-link">
                <p class="text-center text-2xl">
                    {{$transito}}
                </p>
                <p class="uppercase text-center">Sent</p>
                <p class="text-center text-2xl mt-2">
                    <i class="las la-truck"></i>
                </p>
            </a>

            <a href="{{ route('orders.index') . "?status=delivered" }}" class="bg-green-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4 status-link">
                <p class="text-center text-2xl">
                    {{$entregado}}
                </p>
                <p class="uppercase text-center">Delivered</p>
                <p class="text-center text-2xl mt-2">
                    <i class="las la-box-open"></i>
                </p>
            </a>

            <a href="{{ route('orders.index') . "?status=cancelled" }}" class="bg-red-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4 status-link">
                <p class="text-center text-2xl">
                    {{$anulado}}
                </p>
                <p class="uppercase text-center">Cancelled</p>
                <p class="text-center text-2xl mt-2">
                    <i class="las la-times-circle"></i>
                </p>
            </a>
        </section>

        @if ($orders->count())
            <section class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
                <h1 class="text-2xl mb-4">Recent orders</h1>
                <ul>
                    @foreach ($orders as $order)
                        <li>
                            <a href="{{route('orders.show', $order)}}" target="blank" class="flex items-center py-2 px-4 order-link">
                                <span class="w-12 text-center">
                                    @switch($order->shipping_status)
                                        @case('ordered')
                                            <i class="las la-check text-blue-500 opacity-50"></i>
                                            @break
                                        @case('packed')
                                            <i class="las la-box text-yellow-500 opacity-50"></i>
                                            @break
                                        @case('shipped')
                                            <i class="las la-truck text-pink-500 opacity-50"></i>
                                            @break
                                        @case('delivered')
                                            <i class="las la-box-open text-green-500 opacity-50"></i>
                                            @break
                                        @case('cancelled')
                                            <i class="las la-times-circle text-red-500 opacity-50"></i>
                                            @break
                                        @default
                                        <i class="las la-clock text-gray-500 opacity-50"></i>
                                    @endswitch
                                </span>

                                <span>
                                    N° Order: {{$order->id}}
                                    <br>
                                    {{$order->created_at->format('d/m/Y')}}
                                </span>

                                <div class="ml-auto">
                                    <span class="font-bold">
                                        @switch($order->shipping_status)
                                            @case('ordered')
                                                Received
                                                @break
                                            @case('packed')  
                                                Packed
                                                @break
                                            @case('shipped')
                                                Sent
                                                @break
                                            @case('delivered')
                                                Delivered
                                                @break
                                            @case('cancelled')
                                                Cancelled
                                                @break
                                            @default
                                                Pendiente
                                        @endswitch
                                    </span>
                                    <br>
                                    <span class="text-sm">
                                       S/. {{ number_format($order->final_total,2)}}
                                    </span>
                                </div>
                                <span class="ml-2">
                                    <i class="las la-angle-double-right"></i>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @else
        <div class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
            <span class="font-bold text-lg">
                You don't have registered orders
            </span>
        </div>
        @endif
    </div>

    @push('seo')
		<title>Bread in the box</title>
	@endpush

</x-app-layout>