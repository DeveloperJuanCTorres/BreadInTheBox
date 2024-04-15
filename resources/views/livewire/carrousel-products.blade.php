<section class="bg0 p-t-23">
	<div wire:init="loadSection" class="container px-5 px-md-0">
		@if(count($products))
			<div class="text-center mb-4">
				<a href="{{Route('categories.show',$carrousel)}}">
					<h2 class="font-weight-light mt-md-4 title-atlifor-v">
						{{$carrousel->name}}
					</h2>
				</a>
			</div> 
			<div class="col-12">
				<div class="wdgtProducto">
					<div class="carrousel owl-carousel owl-theme">			
						@foreach($products as $item)
							<div class="item pb-3" style="border: 1px solid #002E6A;border-radius: 20px;">
								<!-- Product-1 -->
								<div class="block2">
									<div class="block2-pic hov-img0" style="max-height: 285px;">
										<a href="{{route('products.show',$item)}}">
											<img src="{{config('services.trading.url')}}/uploads/img/{{$item->image}}" alt="IMG-PRODUCT"> 
										</a>
										<a href="{{route('products.show',$item)}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg6 bor2 hov-btn1 p-lr-15 trans-04 ">
											Ver detalle
										</a>
									</div>

									<div class="block2-txt flex-w flex-t p-t-14">
                                        <div class="block2-txt-child1 flex-col-l">
											<div class="mx-auto">
												<a href="{{route('products.show',$item)}}">
													<h3 class="text-center stext-104 cl2 px-2">{{Str::limit($item->name,40)}}</h3>
												</a>
											</div>
											<div class="mx-auto mb-1">
												@if($item->brand)
												<p class="cl2"> {{$item->brand->name}} </p> 
												@else
													Sin marca
												@endif
											</div>
											<div class="mx-auto stext-105 cl2 mb-2">
												<span class="stext-106">Regular</span>
												<span class="ml-4 ">
													S/.{{ number_format($item->variation->first()->sell_price_inc_tax,2)}}
												</span>
											</div> 
										</div>
									</div>
								</div>
								<!-- Fin Product-1 -->	
							</div>
						@endforeach	
					</div>
				</div>
			</div>
		@else
			<div class="row align-items-end justify-content-center ">
				<div  class="my-5 h-48 flex justify-center items-center">
					<div style="border-top-color:transparent" class="w-16 h-16 border-4 border-atlifor border-solid rounded-full animate-spin"></div> 
				</div> 
			</div>
		@endif
	</div>

</section>