@props(['product'])
<li class="bg-white rounded-lg shadow mb-4">
    <article class="d-md-flex">
        <figure class="mb-0">
            <a href="{{route('products.show',$product)}}">
                <img class="w-img"  src="{{config('services.trading.url')}}/uploads/img/{{$product->image}}" alt="IMG-PRODUCT"> 
            </a>
        </figure>

        <div class="flex-1 py-4 px-6 flex flex-col">
            <div class="d-md-flex justify-between">
                <div style="max-width: 75%;">
                    <a href="{{route('products.show',$product)}}">
                    <h1 class="text-lg  title-atlifor-m">
                        {{ $product->name }}
                    </h1>
                    </a>
                    <p class="font-bold text-gray-700 mt-1">
                     S/. {{ number_format($product->variation->first()->sell_price_inc_tax,2)}}
                    </p>
                </div>

                <div class="flex items-center">
                <span class="fs-18 cl14">
                    @for ($i = 1; $i <= 5; $i++)
						@if( round( $product->reviews->avg('rating')) >= $i)
							<i class="zmdi zmdi-star"></i>
						@else
							<i class="zmdi zmdi-star-outline"></i>
						@endif
					@endfor                             
				</span>
                    <span class="text-gray-700 text-sm"> &nbsp; ({{$product->reviews->count()}})</span>
                </div>
            </div>

            <div class="mt-4 md:mt-auto mb-4">
                <a href="{{route('products.show',$product)}}" class="btn btn-outline-primary bor1 size-102">Product View</a>
            </div>
        </div>
    </article>
</li>