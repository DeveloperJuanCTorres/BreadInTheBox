<x-app-layout>
    <div class="fixed-banner"></div>

    <div class="banner-category container-fluid" data-banner="fixed">
    <img src="{{asset('images/contact-us.webp')}}" alt="" class="banner-category__img">
    <div class="banner-category__box-title">
        <h2 class="banner-category__title">Terms and condition</h2>
    </div>
    </div>

    <section class="contacto">
        <div class="contacto__cont container">

            <div class="container ">

                    ....
            </div>
        </div>
    </section>
    @push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
        <meta property="og:image" itemprop="image" content="{{$seo['image']}}" />
	@endpush

</x-app-layout>