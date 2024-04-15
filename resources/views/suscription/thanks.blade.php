<x-app-layout>

  <div class="fixed-banner"></div>

  <div class="banner-category container-fluid" data-banner="fixed">
    <img src="{{asset('images/shopping-cart.webp')}}" alt="" class="banner-category__img fr-fic fr-dii">
    <div class="banner-category__box-title">
      <h1 class="banner-category__title"> Thanks  for subscribing </h1>
    </div>
  </div>

    <div class="p-2">
        <img src="{{asset('/images/thanks.webp')}}" height="250px" width="250px" class="mt-12 mx-auto" alt=""> 
        <h2 class="text-2xl text-center mb-3">Your subscription was successful</h2>
    
        <div class="text-center mb-12">
            <a href="{{ route('suscription.index') }}" class="btn btn-brown-line"> See all my subscriptions <i class="las la-angle-double-right"></i></a>
        </div>
    </div>
    @push('seo')
		<title>Bread in the box | thanks for subscribing</title>
    @endpush
  
</x-app-layout>