@props(['note'])
<li class="bg-white rounded-lg shadow mb-4">
    <article class="d-md-flex">
        <figure class="mb-0">
            <a href="{{route('blog.show', ['id' => $note->id,'slug' => $note->slug])}}">
                <img class="w-img"  src="{{config('services.trading.url')}}/uploads/cms/{{$note->feature_image}}" alt="IMG-PRODUCT"> 
            </a>
        </figure>

        <div class="flex-1 py-4 px-6 flex flex-col">
            <a href="{{route('blog.show', ['id' => $note->id,'slug' => $note->slug])}}">
            <h1 class="text-lg  title-atlifor-m">
                {{ $note->title }}
            </h1>
            </a>
            <p class=" text-gray-600 mt-1">
                {{  Str::limit($note->meta_description, 250)}}
            </p>
        </div>
    </article>
</li>