<x-app-layout>

<div class="sec-banner bg0 p-t-25 p-b-55">

		<div class="container">
			
			<h1 class="txt-center cl3 mt-5 mb-3">Maquinaria &  Vehículos pesados</h1>
			<div class="row">

				@if(!is_null($cargadores))
				<div class="col-md-6 col-lg-4 p-b-30">
					<div class="block1 wrap-pic-w">
						<img src="/images/icons/icon-cargadorfrontal.png" alt="IMG-BANNER">
						<a href="{{route('machinery.category',$cargadores)}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l xcmg">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									{{$cargadores->name}}
								</span>
							</div>
							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Ver categoria
								</div>
							</div>
						</a>
					</div>
					<h2 class="text-center mt-2 ltext-102 cl2">{{$cargadores->name}}</h2>
				</div>
				@endif



				@if(!is_null($minicargadores))
				<div class="col-md-6 col-lg-4 p-b-30">
					<div class="block1 wrap-pic-w">
						<img src="/images/icons/icon-minicargador.png" alt="IMG-BANNER">
						<a href="{{route('machinery.category',$minicargadores)}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l xcmg">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									{{$minicargadores->name}}
								</span>
							</div>
							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Ver categoria
								</div>
							</div>
						</a>
					</div>
					<h2 class="text-center mt-2 ltext-102 cl2">{{$minicargadores->name}}</h2>
				</div>
				@endif



				@if(!is_null($volquetes))
				<div class="col-md-6 col-lg-4 p-b-30">
					<div class="block1 wrap-pic-w">
						<img src="/images/icons/icon-excavadora.png" alt="IMG-BANNER">
						<a href="{{route('machinery.category',$excabadoras)}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l xcmg">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									{{$excabadoras->name}}
								</span>
							</div>
							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Ver categoria
								</div>
							</div>
						</a>
					</div>
					<h2 class="text-center mt-2 ltext-102 cl2">{{$excabadoras->name}}</h2>
				</div>
				@endif



				@if(!is_null($retroexcabadoras))
				<div class="col-md-6 col-lg-4 p-b-30">
					<div class="block1 wrap-pic-w">
						<img src="/images/icons/icon-retroexcavadora.png" alt="IMG-BANNER">
						<a href="{{route('machinery.category',$retroexcabadoras)}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l xcmg">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									{{$retroexcabadoras->name}}
								</span>
							</div>
							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Ver categoria
								</div>
							</div>
						</a>
					</div>
					<h2 class="text-center mt-2 ltext-102 cl2">{{$retroexcabadoras->name}}</h2>
				</div>
				@endif

				@if(!is_null($volquetes))
				<div class="col-md-6 col-lg-4 p-b-30">
					<div class="block1 wrap-pic-w">
						<img src="/images/icons/icon-volquete.png" alt="IMG-BANNER">
						<a href="{{route('machinery.category',$volquetes)}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l xcmg">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									{{$volquetes->name}}
								</span>
							</div>
							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Ver categoria
								</div>
							</div>
						</a>
					</div>
					<h2 class="text-center mt-2 ltext-102 cl2">{{$volquetes->name}}</h2>
				</div>
				@endif

				@if(!is_null($tractocamiones))
				<div class="col-md-6 col-lg-4 p-b-30">
					<div class="block1 wrap-pic-w">
						<img src="/images/icons/icon-tractocamion.png" alt="IMG-BANNER">
						<a href="{{route('machinery.category',$tractocamiones)}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l xcmg">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									{{$tractocamiones->name}}
								</span>
							</div>

							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Ver categoria
								</div>
							</div>
						</a>
					</div>
					<h2 class="text-center mt-2 ltext-102 cl2">{{$tractocamiones->name}}</h2>
				</div> 
				@endif

			</div>
		</div>
	</div>

	@push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
	@endpush
</x-app-layout>