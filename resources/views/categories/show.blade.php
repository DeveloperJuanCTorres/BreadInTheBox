<x-app-layout>
	<!-- Product -->
	<div class="bg0 pt-5 p-b-140 ">
		<div class="container">
            @livewire('category-filter',['category'=>$category])
		</div>
	</div>

	@push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
	@endpush
	
	@push('header')
		<header class="header-v4">
	@endpush
	
	@push('buscador')
		<div class="bg-white px-3 py-1 wrap-header-mobile">
             @livewire('search')
        </div>
	@endpush
</x-app-layout>