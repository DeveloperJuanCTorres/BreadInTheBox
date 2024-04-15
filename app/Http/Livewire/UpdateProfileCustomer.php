<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Dotenv\Parser\Value;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateProfileCustomer extends Component
{

    public $customer =[
        'id'=>null,
        'name'=>null,
        'first_name'=>null,
        'last_name'=>null,
        'supplier_business_name'=>null,
        'mobile'=>null,
        'address_line_1'=>null,
        'zip_code'=>null,
    ];

    public $is_active = false;


    public function mount()
    {
        $this->getCustomer();
    }

    public function getCustomer(){
        $customer = Contact::where('custom_field10',Auth::user()->id)->first();
        $this->customer=[
            'id'=>$customer->id,
            'name'=>$customer->name,
            'first_name'=>$customer->first_name,
            'last_name'=>$customer->last_name,
            'supplier_business_name'=>$customer->supplier_business_name,
            'mobile'=>$customer->mobile,
            'address_line_1'=>$customer->address_line_1,
            'zip_code'=>$customer->zip_code,
        ];
    }

    public function update()
    {
        if(is_null($this->customer['name'])){
            $rules['customer.mobile'] = 'required|digits_between:6,9';
            $rules['customer.address_line_1'] = 'required|max:255';
            $rules['customer.supplier_business_name'] = 'required|max:255';

            $messages = [
                'customer.supplier_business_name'=>'You have to enter the name of the business',
                'customer.mobile'=>'You have to enter the business phone number',
                'customer.address_line_1'=>'You have to enter the company address',
            ];

        }else{
            $rules['customer.mobile' ] = 'required|digits_between:6,9';
            $rules['customer.address_line_1'] = 'required|max:255';
            $rules['customer.first_name'] = 'required|max:255';
            $rules['customer.last_name'] = 'required|max:255';
            $this->customer['name'] = $this->customer['first_name'] .' '.$this->customer['last_name'];

            $messages = [
                'customer.first_name'=>'You have to write your name',
                'customer.last_name'=>'You have to write yout last name',
                'customer.mobile'=>'You have to enter the business phone number',
                'customer.address_line_1'=>'You have to enter the company address',
            ];
        }

        $this->validate($rules,$messages);
        $customer = Contact::find($this->customer['id']);
        $customer->update($this->customer);
        $this->is_active =true;
        // $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.update-profile-customer');
    }
}
