<x-app-layout>

    <div class="fixed-banner"></div>

    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="https://breadinthebox.com/images/bg-imagen-08.png" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title">MONTHLY SPECIALTY BREADS</h1>
        </div>
    </div>

    @if($breadTheMonth)
        <section>
            <h2 class="detail-product__title">​Each month we feature a different sweet specialty bread to go with the season <strong>({{$month}})</strong></h2>
            @livewire('add-cart-item',['product'=>$breadTheMonth])
        </section>
    @endif

    <section class="catalogue">
        <h2 class="detail-product__title m-4">Choose from our variety of fresh breads for delivery</h2>
        <div class="catalogue__products">
            @foreach($products as $product)
                <div class="product-card">
                  
                        <div>
                            <div class="product-card__header">
                                <a href="" class="image-produc">
                                    <img src="{{config('services.trading.url')}}/uploads/img/{{$product->image}}" alt="" class="product-card__img">
                                </a>
                            </div>
                            <div class="product-card__body">
                                <h3 class="product-card__name mb-2"> <span class="title-brown">{{$months[$product->product_custom_field1]}}</span> <br> <strong>Pack of 50 Und</strong> </h3>
                                <h3 class="product-card__name"> {{$product->name}} </h3>
                            </div>
                        </div>

                        @if($product->variation->skip(1)->first())
                            <div class="product-card__footer add_pack" data-id="{{$product->id}}" data-variation="{{$product->variation->skip(1)->first()->id}}" data-price="{{$product->variation->skip(1)->first()->sell_price_inc_tax}}">
                                <p class="product-card__price"><strong>$ {{ number_format($product->variation->skip(1)->first()->sell_price_inc_tax,2)}}</strong></p>
                                <div class="tag-info ordenar"><p class="tag-info__text"><i class="las la-shopping-bag"></i> Add a package</p></div>
                            </div> 
                        @endif               
                   
                </div>
            @endforeach
        </div>
    </section>
    
    @push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
		<meta property="og:image" itemprop="image" content="{{$seo['image']}}" />
	@endpush
</x-app-layout>