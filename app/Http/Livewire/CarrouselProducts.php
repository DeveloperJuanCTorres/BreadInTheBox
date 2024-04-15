<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class CarrouselProducts extends Component
{

    public $carrousel;
    public $products = [];
    public $image = "";

    public function loadSection(){
        $this->products = $this->carrousel->products()->limit(20)->get();
        $this->emit('gilder');
    }

    public function render()
    {
        return view('livewire.carrousel-products');
    }
}
