<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class UpdateSuscriptionInterval extends Component
{
    public $transaction;
    public $frequency = "";

    public function save(){
        
        $messages = [
            'frequency.required'=>'You have to select a frequency',
        ];
        $rules['frequency'] = 'required';
        $this->validate($rules,$messages);

        $this->transaction->recur_interval = $this->frequency;
        $this->transaction->save();
        $this->emit('render');
    }

    public function render()
    {
        return view('livewire.update-suscription-interval');
    }
}
