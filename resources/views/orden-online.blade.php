<x-app-layout>

    <div class="fixed-banner"></div>

    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="https://breadinthebox.com/images/bg-imagen-06.png" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
            <h2 class="banner-category__title">ORDEN ONLINE</h2>
        </div>
    </div>

    <div class="catalogue">
        <div class="catalogue__products">
            @if(count($products))
                @foreach($products as $product)
                <div class="product-card">
                    <a href="{{route('products.show',$product)}}">
                        <div>
                            <div class="product-card__header">
                                <img src="{{config('services.trading.url')}}/uploads/img/{{$product->image}}" alt="" class="product-card__img">
                            </div>
                            <div class="product-card__body">
                                <h3 class="product-card__name"> {{$product->name}} </h3>
                            </div>
                        </div>
                        <div class="product-card__footer">
                            <p class="product-card__price">
                                <strong>${{ number_format($product->variation->first()->sell_price_inc_tax,2)}}</strong>
                            </p>
                            <div class="tag-info ordenar"><p class="tag-info__text">See product </p></div>
                        </div>
                    </a>
                </div>
                @endforeach
            @else
                <h3>Loading...</h3>
            @endif
        </div>
    </div>
    @push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
		<meta property="og:image" itemprop="image" content="{{$seo['image']}}" />
	@endpush
</x-app-layout>