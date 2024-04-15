<div class="flex items-center" x-data>
    <button class="btn btn-outline-primary btn-num-product-down"
        {{$qty > 1? '':'disabled'}}
        wire:loading.attr="disabled"
        wire:target="decrement"
        wire:click="decrement">
        <i class="las la-minus"></i>
    </button>

    <span class="mx-2 text-gray-700">&nbsp;  {{$qty}} &nbsp; </span>
    
    <button class="btn btn-outline-primary btn-num-product-up"
        {{$qty >= $quantity? 'disabled':''}}
        wire:loading.attr="disabled"
        wire:target="increment"
        wire:click="increment">
        <i class="las la-plus"></i>
    </button>
</div>