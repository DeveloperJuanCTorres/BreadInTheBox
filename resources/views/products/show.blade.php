<x-app-layout>
	<div class="fixed-banner "></div> 

	<div class="banner-category container-fluid" data-banner="fixed">
		<img src="{{asset('images/comprar.webp')}}" alt="" class="banner-category__img fr-fic fr-dii">
		<div class="banner-category__box-title">
		<h1 class="banner-category__title">{{$product->name}}</h1>
		</div>
	</div>

	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-55 p-b-50">	
       	<div></div>
        @livewire('add-cart-item',['product'=>$product])
	</section> 

	<section class="empieza-pedido container-fluid">
	<div class="container">	
		<h1 class="detail-product__title mb-4">Related Products</h1>
		<div class="category-slider__wrapper ">
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
		</div>
    </section>

	@push('css')
        <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
       <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">  
    @endpush

	@push('script')
        <script src="{{asset('/js/owl.carousel.min.js')}}"></script>
        <script>
            $(document).ready(function(){
            
                /*  Carrousel  */
                var owl = $('#olwProduct');
                owl.owlCarousel(
                    {
						loop:true,
                        responsive:{
                            0:{
                                items:1,
                            },
                            320:{
                                items:1,
                            },
                            480:{
                                items:2,
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
                                items:4,
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
                if (scrWidth > 700 && scrWidth < 1024 && slideCounter > 3) {
                    $('.category-slider__arrow-left').addClass('active')
                    $('.category-slider__arrow-right').addClass('active')
                }
                if (scrWidth > 1024 && slideCounter > 4) {
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
        <meta property="og:image" itemprop="image" content="{{config('services.trading.url')}}/uploads/img/{{$product->image}}" />
	@endpush

</x-app-layout>