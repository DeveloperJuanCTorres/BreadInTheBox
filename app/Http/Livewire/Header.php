<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Header extends Component
{
    protected $listeners = ['render'];
    
    public function render()
    {
        return view('livewire.header');
    }
}
