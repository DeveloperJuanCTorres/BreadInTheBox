<x-app-layout>

  <div class="fixed-banner"></div>

  <div class="banner-category container-fluid" data-banner="fixed">
    <img src="{{asset('images/shopping-cart.webp')}}" alt="" class="banner-category__img fr-fic fr-dii">
    <div class="banner-category__box-title">
      <h1 class="banner-category__title"> Sorry </h1>
    </div>
  </div>

    <div class="container">
        <img src="{{asset('/images/card-error.webp')}}" height="250px" width="250px" class="mt-12 mx-auto" alt=""> 
        <h2 class="text-2xl text-center mb-3">Your pay ement has been declined</h2>
        <p class="text-lg  text-center m-5">Unfortunately your payment has not been approved by the payment platform, we hope this is resolved soon, and you can return again for your purchase</p>
    
        <div class="text-center mb-12">
            <a href="{{ route('home') }}" class="btn btn-brown-line">Go to Home <i class="las la-angle-double-right"></i></a>
        </div>
    </div>
    @push('seo')
		<title>Bread in the box | Sorry </title>
    @endpush
  
</x-app-layout>