<x-app-layout>

    <div class="sec-banner bg0 p-t-95 p-b-55">
		<div class="container">
        
        @if($machinaries->count())
            <h1 class="txt-center cl2 mb-4">{{$category->name}}</h1>
			<div class="row">	
                @foreach($machinaries as $machinary)
                    <div class="col-md-6 col-lg-4 p-b-30 ">
                        <!-- Block1 -->
                        <div class="block1 wrap-pic-w">
                            <img src="{{config('services.trading.url')}}/uploads/img/{{$machinary->image}}" alt="IMG-PRODUCT"> 
                            <a href="{{route('machinery.show',$machinary)}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                                <div class="block1-txt-child1 flex-col-l xcmg">
                                    <span class="block1-name ltext-102 trans-04 p-b-8">
                                        {{$machinary->name}}
                                    </span>
                                </div>

                                <div class="block1-txt-child2 p-b-4 trans-05">
                                    <div class="block1-link stext-101 cl0 trans-09">
                                        Ver detalle
                                    </div>
                                </div>
                            </a>
                        </div>
                        <p class="text-center mt-2 stext-104 cl2">{{$machinary->name}}</p>
                    </div>
                @endforeach
			</div>
        @else
            <h2 class="text-center"> No hay productos</h2>
        @endif
	</div>
</div>

    @push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
	@endpush
    
</x-app-layout>