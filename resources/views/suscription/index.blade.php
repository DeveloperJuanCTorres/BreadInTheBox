<x-app-layout>
    <div class="fixed-banner "></div> 
    
    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/bg-bread-special.webp')}}" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title"> My suscriptions </h1>
        </div>
    </div>

    <div class="container py-12">

        @if ($orders->count())
        <x-table-responsive>
            <section class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
                <ul>
                    
                    @foreach ($orders as $order)
                        <li>
                            <span class="flex items-center py-2 px-4 order-link">
                                
                                <span class="w-12 text-center">
                                    <i class="las la-bell text-blue-500 text-lg"></i>
                                </span>

                                <span>
                                       <strong>Subscription:</strong> {{$order->recur_interval}} day interval
                                    <br>
                                       <strong>Next order:</strong> {{$order->created_at->format('d/m/Y')}}
                                    <br>
                                        <strong>Total amount:</strong> $ {{ number_format($order->final_total,2)}}
                                </span>

                                <span class="ml-auto">
                                    <button class="btn"> <i class="las la-minus-circle mr-1"></i> Suspender</button>
                                </span>

                                <span class="ml-2">
                                    <button class="btn btn-danger"><i class="las la-times mr-1"></i> Cancel</button>
                                </span>

                                <span class="ml-2">
                                    <a href="{{route('suscription.show',$order)}}" target="blank" class="btn btn-success"><i class="las la-eye mr-1"></i> See detail </a>
                                </span>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </section>
        </x-table-responsive>
        @else
        <div class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
            <span class="font-bold text-lg">
                You don't  have any registered subscription
            </span>
        </div>
        @endif
    </div>

    @push('seo')
		<title>Bread in the box | My suscriptions</title>
	@endpush
</x-app-layout>