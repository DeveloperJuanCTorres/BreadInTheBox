<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Models\Contact;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {

            if($input['list-radio']=='person'){
                Validator::make($input, [
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'mobile' => ['required', 'numeric','digits_between:6,12'],
                    'address' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'zip' => ['required'],
                    'password' => $this->passwordRules(),
                    'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
                ])->validate();

                try {
                    $user = User::create([
                        'user_type' => 'cliente',
                        'name' => $input['first_name'].' '.$input['last_name'],
                        'first_name' => $input['first_name'],
                        'last_name' => $input['last_name'],
                        'username' => $input['email'],
                        'email' => $input['email'],
                        'password' => Hash::make($input['password']),
                        'language' => 'en'
                    ]);

                    Contact::create([
                        'business_id' => 12,
                        'type' => "customer",
                        'name' => $input['first_name'].' '.$input['last_name'],
                        'first_name' => $input['first_name'],
                        'last_name' => $input['last_name'],
                        'contact_status' => "active",
                        'city'=>'Denver',
                        'state'=>'CO',
                        'country' => "USA",
                        'address_line_1'  => $input['address'],
                        'zip_code'=> $input['zip'],
                        'mobile' => $input['mobile'],
                        'created_by' => 2, //Es un Usurio registrado en el sistema comercial que representa a la ecommerce
                        'custom_field10'=>$user->id,
                    ]);
                }catch (\Throwable $th) {
                    dd($th->getMessage());
                    // return view('respuesto',compact('th'));
                    // return abort(404);
                }

            }else{
                Validator::make($input, [
                    'busines' => ['required', 'string', 'max:255'],
                    'mobile' => ['required', 'numeric','digits_between:6,9'],
                    'address' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => $this->passwordRules(),
                    'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
                ])->validate();

                try {
                    
                    $user = User::create([
                        'user_type' => 'cliente',
                        'name' => $input['busines'],
                        'first_name' => 'Bus.',
                        'last_name' => $input['busines'],
                        'username' => $input['email'],
                        'email' => $input['email'],
                        'password' => Hash::make($input['password']),
                        'language' => 'en'
                    ]);

                    Contact::create([
                        'business_id' => 12,
                        'type' => "customer",
                        'supplier_business_name' => $input['busines'],
                        'contact_status' => "active",
                        'city'=>'Denver',
                        'state'=>'CO',
                        'country' => "USA",
                        'address_line_1'  => $input['address'],
                        'zip_code' => $input['zip'],
                        'mobile' => $input['mobile'],
                        'created_by' => 2, //Es un Usurio registrado en el sistema comercial que representa a la ecommerce
                        'custom_field10'=>$user->id,
                    ]);
                }catch (\Throwable $th) {
                    dd($th->getMessage());
                    // return abort(404);
                }
            }

            try {
                $user->createAsStripeCustomer();    
            } catch (\Throwable $th) {
                dd($th);
            }
            
            return $user;
    }
}
