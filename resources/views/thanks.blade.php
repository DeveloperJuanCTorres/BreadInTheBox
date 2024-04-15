
<x-app-layout>
    <div class="fixed-banner"></div>

    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/about.webp')}}" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title">Thank you</h1>
        </div>
    </div>


    <div class="p-2">
        <img src="{{asset('/images/thanks.webp')}}" height="250px" width="250px" class="mt-12 mx-auto" alt=""> 
        <h2 class="text-center mt-3">Thanks  for your purchase!</h2>
        <h3 class="text-center mb-2"># Orde: ORDE-{{$transaction->id}}</h3>
       
        <div class="text-center mb-12">
            <a href="{{ route('orders.index') }}" class="btn btn-primary bor1 size-102">See my orders</a>
        </div>
    </div>
    @push('seo')
		<title>Bread in the box</title>
	@endpush
</x-app-layout>