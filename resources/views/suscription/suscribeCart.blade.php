<x-app-layout>

    <div class="fixed-banner"></div>
    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/question.webp')}}" alt="questions" class="banner-category__img fr-fic fr-dii">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title">Suscription</h1>
        </div>
    </div>
    
    @if (Auth::user()->idPaymentMethod)
        @livewire('add-suscription-cart')
    @else
        <div class="container">
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4  my-5" role="alert">
                <p class="text-xl font-bold">Remember</p>
                <p class="text-lg">To register a subscription you first have to register a payment method <a class="font-bold" href="/user/profile">“in this link”</a> or you can go to the payment methods section in your profile</p>
            </div>
        </div>
    @endif

    @push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
        <meta property="og:image" itemprop="image" content="{{$seo['image']}}" />
	@endpush

   
</x-app-layout>