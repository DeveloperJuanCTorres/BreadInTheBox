<x-app-layout>
	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-55 p-b-50">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="slick3 gallery-lb">
								<div class="item-slick3"> 
									<div class="wrap-pic-w pos-relative">
										<img src="{{config('services.trading.url')}}/uploads/img/{{$product->image}}" alt="IMG-PRODUCT"> 	
									</div>
								</div>
							</div>
						</div> 
					</div> 
				</div>
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="px-4 px-md-0   pr-md-5 p-t-5 p-lr-0-lg"> 
						<h4 class="mtext-105 cl2 js-name-detail ">
							{{$product->name}}
						</h4>
                        <span class="fs-18 cl14">
							@for ($i = 1; $i <= 5; $i++)
								@if( round($product->reviews->avg('rating')) >= $i)
									<i class="zmdi zmdi-star"></i>
								@else
									<i class="zmdi zmdi-star-outline"></i>
								@endif
							@endfor            
						</span> ({{ $product->reviews->count() }})<br><hr>

                        <div class="border-detail mb-3">
							<h2 class="mtext-112 cl3 ml-2">
                               {{$product->product_custom_field1}}
                            </h2> 
                        </div>
                        <div class="border-detail mb-3">
							<h2 class="mtext-112 cl3 ml-2">
                                {{$product->product_custom_field2}}
                            </h2> 
                        </div>
                        <div class="border-detail mb-3">
							<h2 class="mtext-112 cl3 ml-2">
                                {{$product->product_custom_field3}}
                            </h2> 
                        </div>
						<div class="border-detail mb-3">
                            
                            <h2 class="mtext-112 cl3 ml-2">
                                {{$product->product_custom_field4}}
                            </h2> 
                        </div>

                        <p><b class="cl2">Llama para cotizar: </b><i class="zmdi zmdi-phone"></i> +51 957233959</p>
						@if($pdf)
						<div class="flex-w flex-m p-t-30">
                            <a target="_blank" href="{{config('services.trading.url')}}/uploads/media/{{$pdf->file_name}}" class="btn btn-primary bor1 size-102 bg-purpura w-full">
                                Descargar Ficha tecnica <i class="zmdi zmdi-download"></i> 
                            </a>
						</div>
						@endif
					</div>
				</div> 
			</div> 
			<div class="p-b-20">
				<!-- Tab01 -->
				<div class="tab01">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item p-b-10">
							<a class="nav-link active" data-toggle="tab" href="#description" role="tab"> Detalles del producto</a>
						</li>
						<li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab"> Comentarios </a> 
							<!-- <a class="nav-link" data-toggle="tab" href="#reviews" role="tab"> Reviews  ($product->reviews->count()) </a> -->
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content p-t-43">
						<!-- - -->
						<div class="tab-pane fade show active" id="description" role="tabpanel">
							<div class="how-pos2 p-lr-15-md">
								<p class="stext-102 cl6">
									{!! $product->product_description !!}
								</p>
							</div>
						</div>
						<!-- - -->
						<div class="tab-pane fade" id="reviews" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<div class="p-b-30 m-lr-15-sm">
									{{-- @can('review', $product) --}}
									@if(Auth::check())
											<!-- Add review -->
											<form action="{{route('review.store',$product)}}" method="POST" class="mt-1 mb-5 w-full">
												@csrf
												<h5 class="mtext-108 cl2 p-b-7">Deja tu comentario:</h5>

													<textarea id="editor" name="comment"></textarea>
													<x-jet-input-error for="comment"></x-jet-input-error>
													<div class="flex-w flex-m">
														<span class="stext-102 cl3 m-r-16">
														    Tu clasificación
														</span>

														<span class="wrap-rating fs-18 cl14 pointer">
															<i class="item-rating pointer zmdi zmdi-star-outline"></i>
															<i class="item-rating pointer zmdi zmdi-star-outline"></i>
															<i class="item-rating pointer zmdi zmdi-star-outline"></i>
															<i class="item-rating pointer zmdi zmdi-star-outline"></i>
															<i class="item-rating pointer zmdi zmdi-star-outline"></i>
															<input class="dis-none" type="number" name="rating">
														</span>
													</div>
													<x-jet-input-error for="rating"></x-jet-input-error>

													<div class="text-center mt-3">
													
														<x-jet-button class="btn btn-primary bor1 size-102 bg-purpura w-full">
															&nbsp;&nbsp;&nbsp;	Enviar &nbsp;&nbsp;&nbsp;
														</x-jet-button>
													</div>
											</form>
										@else
											<p class="text-center">Para dejar tu comentario tienes que iniciar sesión</p> 
										@endif
										{{-- @endcan--}}

										<!-- Review -->
										@if($product->reviews->isNotEmpty())
											<h5 class="mtext-108 cl2 p-b-15">Comentarios:</h5>
											@foreach($product->reviews as $review)
												<div class="flex-w flex-t">
													<div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
														<img src="{{$review->user->profile_photo_url}}" alt="AVATAR">
													</div>
													<div class="size-207">
														<div class="flex-w flex-sb-m p-b-17">
															<span class="p-r-20">
																<span class="mtext-107 cl2 ">{{$review->user->name}}</span>
																<p style="font-size: 14px;">{{$review->created_at->diffForHumans()}}</p>
															</span>
															<span class="fs-18 cl14">
																@for ($i = 1; $i <= 5; $i++)
																	@if($review->rating >= $i)
																		<i class="zmdi zmdi-star"></i>
																	@else
																		<i class="zmdi zmdi-star-outline"></i>
																	@endif
																@endfor 
															</span>
														</div>
														<p class="stext-102 cl6">
															{!! $review->comment !!}
														</p>
													</div>
												</div>
											@endforeach
										@else
											<div class="text-center">
												<b>No hay comentarios</b>
											</div>
										@endif 

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> 



	<!-- Modal Talla -->
	<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
		<div class="overlay-modal1 js-hide-modal1"></div>
		<div class="container">
			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
				<button class="how-pos3 hov3 trans-04 js-hide-modal1">
					<img src="/images/icons/icon-close.png" alt=" Close">
				</button>
				<div class="row">
					<div class="col-md-12 p-b-30">
						<div class="p-l-25 p-r-30 p-lr-0-lg text-center">
							@if(!is_null($product->image_size))
							<img src="{{Storage::url($product->image_size)}}" alt="IMG-PRODUCT" class="mx-auto" style="width: 500px;"> 
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
	@endpush

	@push('script')
        <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
		<script>
			ClassicEditor
				.create( document.querySelector( '#editor' ), {
					toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList','blockQuote'],
					
				} )
				.catch( error => {
					console.log( error );
				} );
		</script>
    @endpush

	@push('header')
		<header class="header-v4">
	@endpush

</x-app-layout>