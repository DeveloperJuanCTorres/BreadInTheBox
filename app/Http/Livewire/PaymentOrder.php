<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class PaymentOrder extends Component
{
    use AuthorizesRequests;
    public $transaction;
    protected $listeners = ['payOrder'];

    public function mount(Transaction $transaction){
        $this->transaction = $transaction;
    }

    public function payOrder(){
        $this->transaction->status = 2;
        $this->transaction->save();
        return redirect()->route('transactions.show', $this->transaction);
    }


    public function render()
    {
        $this->authorize('author', $this->transaction);
        $this->authorize('payment', $this->transaction);
        $items = $this->transaction->transaction_sell_line;


        $dominio = config('app.url');
        $seo = array(
            'title'         => 'Bread in the box | Payment method',
            'description'   => 'BAKERY ECOMERCE',
            'keywords'      => 'Bread,Bakery,Colorado',
            'image'         => $dominio.'/images/logo-seo.png',
        );

        return view('livewire.payment-order', compact('items','seo'));
    }
}
