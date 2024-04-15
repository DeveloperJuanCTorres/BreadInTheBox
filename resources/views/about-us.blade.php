<x-app-layout>

  <div class="fixed-banner"></div>

  <div class="banner-category container-fluid" data-banner="fixed">
    <img src="{{asset('images/about.webp')}}" alt="" class="banner-category__img fr-fic fr-dii">
    <div class="banner-category__box-title">
      <h1 class="banner-category__title">ABOUT US</h1>
    </div>
  </div>

  <div class="static-page__container">
        <h2 class="text-center">We are proud of our team!</h2>
        <p class="text-center">
          They are the artists who make each piece of bread a delicious work of art. You are probably wondering why our specialty
          breads are so delicious, well... our bakers have shared with you the secret ingredients:
        ​</p>
        <ul class="text-center">
          <li>3 cups of love <i class="las la-heart"></i></li>
          <li>6 spoons of dedication <i class="las la-hands-helping"></i></li>
          <li>1 tablespoon of passion <i class="las la-fire-alt"></i></li>
          <li>A pinch of joy <i class="las la-smile-beam"></i></li>
        </ul>
      <img class="mt-4" src="{{asset('images/cooking.webp')}}" alt="">
  </div>
  @push('seo')
		<title>{{$seo['title']}}</title>
    <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
		<meta property="og:image" itemprop="image" content="{{$seo['image']}}" />
	@endpush
  
</x-app-layout>