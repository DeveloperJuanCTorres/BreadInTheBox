<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShoppingCart extends Component
{

    protected $listeners = ['render'];

    public function destroy(){
        \Cart::clear();
        $this->emitTo('dropdown-cart', 'render');
        $this->emitTo('header','render');
    }

    public function delete($rowID){
        \Cart::remove($rowID);
        $this->emitTo('dropdown-cart', 'render');
        $this->emitTo('header','render');
    }
    
    public function render()
    {
        $dominio = config('app.url');
        $seo = array(
            'title'         => 'Bread in the box | Shopping cart',
            'description'   => 'BAKERY ECOMERCE',
            'keywords'      => 'Bread,Bakery,Colorado',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('livewire.shopping-cart',compact('seo'));
    }
}
