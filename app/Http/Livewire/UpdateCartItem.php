<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UpdateCartItem extends Component
{

    public $rowId, $qty, $quantity;

    public function mount(){
        $item = \Cart::get($this->rowId); 
        $this->qty = $item->quantity;
        // $this->quantity = quantity($item->attributes->product_id, $item->attributes->variation_id);
        $this->quantity = 50;
    }

    public function decrement(){
        $this->qty = $this->qty - 1;
        \Cart::update($this->rowId, array(
            'quantity' => -1,
        ));
        $this->emit('render');
    }

    public function increment(){
        $this->qty = $this->qty + 1;
        \Cart::update($this->rowId, array(
            'quantity' => 1,
        ));
        $this->emit('render');
    }

    public function render()
    {
        return view('livewire.update-cart-item');
    }
}
