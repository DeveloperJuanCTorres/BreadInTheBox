<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\Contact;
use Carbon\Carbon;

class Suscription extends Component
{

    protected $listeners = ['delete'];
    public $suscriptions;
    public $contact;

    public function mount(){
        $this->contact = Contact::where('custom_field10', auth()->user()->id)->first();
        $this->getSuscriptions();
    }

    public function getSuscriptions(){
         $this->suscriptions = Transaction::query()->where('contact_id', $this->contact->id)->where('is_recurring',1)->orderBy('id','DESC')->get();
    }

    public function delete($id){
        // GroupProduct::where('product_id',$id)->delete();
        $suscription = Transaction::find($id);
        $suscription->recur_stopped_on = Carbon::now();
        $suscription->is_recurring = 0;
        $suscription->save();
        $this->getSuscriptions();
    }

    public function suspende($id){
        $suscription = Transaction::find($id);
        $suscription->recur_stopped_on = Carbon::now();
        $suscription->save();
        $this->getSuscriptions();
    }

    public function activate($id){
        $suscription = Transaction::find($id);
        $suscription->recur_stopped_on = null;
        $suscription->save();
        $this->getSuscriptions();
    }

    public function render()
    {
        return view('livewire.suscription');
    }
}
