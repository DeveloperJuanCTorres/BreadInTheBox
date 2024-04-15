<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
    @endpush

    <div class="home-loader">

        <div class="fixed-banner "></div> 

        <div class="owl-carousel owl-theme" id="olwHome">
            <div> 
                <img src="{{asset('images/banner-1.webp')}}?v=1993.1.1" alt="" class="carrousel-home__img fr-fic fr-dib">
            </div>
            <div> 
                <img src="{{asset('images/banner-2.webp')}}?v=1993.1.1" alt="" class="carrousel-home__img fr-fic fr-dib">
            </div>
            <div> 
                <img src="{{asset('images/banner-3.webp')}}?v=1993.1.1" alt="" class="carrousel-home__img fr-fic fr-dib">
            </div>
        </div> 

        <section class="empieza-pedido container-fluid">
            <h1 class="detail-product__title mb-4">Create the combination for your next breakfast</h1>
            <div class="category-slider__wrapper">
                <div class="category-slider__bottom">
                    <div class="category-slider__arrow-left">
                        <i class="las la-chevron-left"></i>
                    </div>
                    <div class="category-slider__arrow-right">
                        <i class="las la-chevron-right"></i>
                    </div>
                    @if(count($products))
                    <ul class="category-slider__list owl-carousel" id="olwProduct">
                        @foreach($products as $product)
                            <li class="category-slider__item  " >
                                <a href="{{route('products.show',$product)}}">
                                    <img src="{{config('services.trading.url')}}/uploads/img/{{$product->image}}" width="" height=""  class="category-slider__img fr-fic fr-dib">
                                    <span>{{$product->name}}</span>
                                    <strong>${{ number_format($product->variation->first()->sell_price_inc_tax,2)}}</strong>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @else
                    <h2>Loading...</h2>
                    @endif
                <div>
            </div>
        </section>

        <div class="text-center mb-5">
            <a href="{{route('orden')}}" class="btn btn-brown-line mb-5 "> <span class="mx-5">See more</span> </a>
        </div>
    


        @if($breadTheMonth)
        <section class="home-conocenos">
            <div class="home-conocenos__cont">
                <div class="home-conocenos__img left">
                    <img src="{{asset('images/trigo.webp')}}" alt="Left" class="fr-fil fr-dib">
                </div>
                <div class="home-conocenos__text-cont">
                    <div class="home-conocenos__brand">
                        <img src="{{asset('images/logo-marron.webp')}}" alt="Bread the Month" class="fr-fic fr-dib">
                    </div> 
                    <div class="home-conocenos__text">
                        <h2 class="month-sub__title "> Bread of the Month "{{$month}}"</h2>
                        <p class="box-subtotal__text text-center"> {{$breadTheMonth->name}} <strong class="ml-2">${{ number_format($breadTheMonth->variation->first()->sell_price_inc_tax,2)}}</strong> </p>
                        <span class="mt-2">Subscribe to the bread of the month and receive the benefits and discounts for being a frequent customer </span>
                        <!-- breadTheMonth->product_description -->
                    </div><div class="home-conocenos__action">
                        <a class="btn" href="{{route('suscription.create',$breadTheMonth)}}"><i class="las la-bell"></i> Subscribe</a>
                        <a class="btn" href="{{route('monthly.specialty')}}"><i class="las la-bread-slice"></i> See detail</a>
                    </div>
                </div>
                <div class="home-conocenos__img right">
                    <img src="{{asset('images/trigo.webp')}}" alt="Right" class="fr-fil fr-dib">
                </div>
            </div>
        </section>
        @endif
        
        <section class="home-instagram container-fluid">
            <div class="home-instagram__top">
                <p class="home-instagram__hash">
                    <span class="lab la-instagram"></span>
                    <span class="home-instagram__ht">Instagram @breadinthebox_</span>
                </p>
            </div>
            <div class="home-instagram__bottom">
                <ul class="home-instagram__list"></ul>
            </div>
        </section>
    </div>

    @push('script')
        <script src="{{asset('/js/owl.carousel.min.js')}}"></script>
        <script>
            $(document).ready(function(){
                $('#olwHome').owlCarousel({
                    loop:true,
                    nav:false,
                    responsive:{
                        0:{
                            items:1
                        },
                        600:{
                            items:1
                        },
                        1000:{
                            items:1
                        }
                    }
                });

                /*  Carrousel  */
                var owl = $('#olwProduct');
                owl.owlCarousel(
                    {
                        loop:true,
						// margin:10,
                        responsive:{
                            0:{
                                items:1,
                            },
                            320:{
                                items:1,
                            },
                            480:{
                                items:1,
                            },
                            600:{
                                items:3,
                            },
                            800:{
                                items:3,
                            },
                            1024:{
                                items:4,
                            },
                            1124:{
                                items:5,
                            },
                        }
                    }
                );
                let scrWidth = window.innerWidth
                let slideCounter = $('.category-slider__item').length
                if (scrWidth > 300 && scrWidth < 700 && slideCounter > 2) {
                    $('.category-slider__arrow-left').addClass('active')
                    $('.category-slider__arrow-right').addClass('active')
                }
                if (scrWidth > 700 && scrWidth < 1024 && slideCounter > 4) {
                    $('.category-slider__arrow-left').addClass('active')
                    $('.category-slider__arrow-right').addClass('active')
                }
                if (scrWidth > 1024 && slideCounter > 5) {
                    $('.category-slider__arrow-left').addClass('active')
                    $('.category-slider__arrow-right').addClass('active')
                }
                $('.category-slider__arrow-right').click(function() {
                    owl.trigger('next.owl.carousel');
                })
                $('.category-slider__arrow-left').click(function() {
                    owl.trigger('prev.owl.carousel');
                })
            });
        </script>
    @endpush

    @push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
		<meta property="og:image" itemprop="image" content="{{$seo['image']}}" />
	@endpush
</x-app-layout>