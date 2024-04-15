<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Contact;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function author(User $user, Transaction $transaction){
        $contact = Contact::where('custom_field10',$user->id)->first();
        if ($transaction->contact_id == $contact->id) {
            return true;
        }else{
            return false;
        }
    }

    public function payment(User $user,Transaction $transaction){

        if ($transaction->status == 'ordered') {
            return true;
        }else{
            return false;
        }
    }
}
