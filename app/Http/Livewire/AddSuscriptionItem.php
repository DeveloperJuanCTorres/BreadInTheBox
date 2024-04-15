<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TaxRate;
use App\Models\Transaction;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Models\ReferenceCount;
use App\Models\TransactionSellLine;
use App\Models\Variation;
use Carbon\Carbon;
use Laravel\Cashier\Exceptions\IncompletePayment;
use App\Models\User;
use App\models\TransactionPayment;
use App\Models\InvoiceScheme;


class AddSuscriptionItem extends Component
{
    public $listeners = ['suscription_product'];
    public $contact = null;
    public $product;
    public $frequency = "", $references;
    public $startDay, $day, $dateSelected;
    public $quantity, $qty = 1, $price = 0; 
    public $tax, $tax_cost, $shipping, $shipping_cost, $total,$taxRate;
    public $bread_shape = "";

    public function mount(){
        $this->contact = Contact::where('custom_field10',Auth::user()->id)->first();
        $this->quantity = 50;
        $this->price = $this->product->variation->first()->sell_price_inc_tax;
        $this->taxRate = TaxRate::where('name','Colorado')->first();
        $delivery = TaxRate::where('name','delivery')->first();
        $this->tax = ($this->taxRate->amount/100);
        $this->shipping_cost = $delivery->amount;
        $this->shipping = $this->shipping_cost;
        $this->tax_cost =  $this->price * $this->tax;
        $this->total = $this->tax_cost + $this->price +  $this->shipping;



        //determinar si es un pan especial o uno normal
        // if(empty($this->product->product_custom_field1)){
        //     $this->type = "simple";
        // }else{
        //     $this->type = "special";
        // }
    }

    public function decrement(){

        $this->qty = $this->qty -1;
        $this->tax_cost =  $this->price + $this->tax * $this->qty;
        if(($this->price * $this->qty)> 25){
            $this->shipping = 0;
        }else{
            $this->shipping = $this->shipping_cost;
        }
        $this->total = ($this->price * $this->qty) +$this->tax_cost +  $this->shipping;
    }

    public function incrementar(){

        $this->qty = $this->qty +1;
        $this->tax_cost =  $this->price + $this->tax * $this->qty;
        if(($this->price * $this->qty)> 25){
            $this->shipping = 0;
        }else{
            $this->shipping = $this->shipping_cost;
        }
        $this->total = ($this->price * $this->qty) +$this->tax_cost +  $this->shipping;
    }

    public function suscription_product(){

        if($this->bread_shape = "Sliced"){
            $this->bread_shape =  $this->product->name." has to be sliced.";
        }

        //Comparar la fecha actual con la selecionada y validar si es mayor
        $dateAux = date("Y-m-d"); //fecha actual 
        $dateNow =date("Y-m-d",strtotime($dateAux."+ 1 days"));// le sumo un dia para que el pedido sea 48 horas antes

        $dateSelected = Carbon::parse($this->startDay)->format('Y-m-d');  //fecha seleccionada en datepiker
        if($dateNow < $dateSelected){
            $this->dateSelected = $dateSelected;
        }else{
            $this->dateSelected = null;
        }

        $messages = [
            'dateSelected.required'=>'Delivery is made at least two days in advance.',
            'frequency.required'=>'You have to select a frequency',
            'day.between'=>'Deliveries are only Monday and Tuesday',
            'day.required'=>'You have to select a day'
        ];

        $rules['dateSelected'] = 'required';
        $rules['frequency'] = 'required';
        $rules['day'] = 'required|integer|between:1,2';
        $this->validate($rules,$messages);

         //realizar pago
         $auxTotal = round($this->total * 100);
         $totalStripe = (int)$auxTotal;

         try {
             $user = User::find(auth()->user()->id);
             $user->charge($totalStripe,$user->idPaymentMethod);  
             $isPaid = true; 
         } catch (IncompletePayment $exception) {
            $isPaid =  false;
            dd($exception);
         }

        // ------------------------
        if($isPaid){ 
            $variation = Variation::where('product_id',$this->product->id)->first();
            $variation_id = $variation->id;
            $form_date = Carbon::parse($this->startDay)->subDay()->format('Y-m-d H:i:s');//fecha seleccionada en datepiker con un dia menos para que el Job lo genere un dia antes
            $delivery_date = Carbon::parse($this->startDay)->format('Y-m-d H:i:s');
            $reference  =  $this->setAndGetReferenceCount('subscription');
            //12 es el ID del  negocio y 16 es el correlativo de las facturas;
            $invoice_no = $this->getInvoiceNumber(12,16);
            $anio = date("Y");
            // -----Crear la orden de compra------
            $transaction = new Transaction();
            $transaction->business_id = 12;
            $transaction->location_id = 12;
            $transaction->status = 'final' ;
            $transaction->type = 'sell';
            $transaction->payment_status = 'paid'; //*cambio
            $transaction->contact_id = $this->contact->id;
            $transaction->invoice_no =  $invoice_no; //Numero de Referencia
            $transaction->subscription_no =  $anio.'-'.$reference; //Numero de referencia de la suscription
            $transaction->transaction_date = $form_date;
            $transaction->total_before_tax = ($this->price * $this->qty);
            $transaction->tax_id = $this->taxRate->id;
            $transaction->tax_amount = $this->tax_cost;
            $transaction->discount_type = 'percentage';
            $transaction->rp_redeemed = 0;
            $transaction->rp_redeemed_amount = 0.00;
            $transaction->shipping_details = $this->references;
            $transaction->shipping_address = $this->contact->address_line_1 .' ('.$this->contact->state.', '.$this->contact->city.', '.$this->contact->zip_code.')';
            $transaction->shipping_status = 'ordered';
            $transaction->delivery_date = $delivery_date;
            $transaction->delivered_to = $this->contact->supplier_business_name.''.$this->contact->first_name.' '.$this->contact->last_name;
            $transaction->shipping_charges = $this->shipping; 
            $transaction->shipping_custom_field_1 = $this->contact->mobile;
            $transaction->final_total = $this->total; //total mas envio 
            $transaction->is_direct_sale = 1 ;
            $transaction->exchange_rate = 1.00 ;
            $transaction->created_by = 65; //ID del Ecommerce como vendedor
            $transaction->mfg_production_cost = 0.00 ;
            $transaction->mfg_production_cost_type = "percentage";
            $transaction->mfg_is_final = 0;
            $transaction->is_recurring = 1;
            $transaction->recur_interval = $this->frequency;
            $transaction->recur_interval_type = 'days';
            $transaction->recur_repetitions = 0;
            $transaction->essentials_duration = 0;
            $transaction->essentials_amount_per_unit_duration = 0; 
            $transaction->rp_earned = 0;
            $transaction->is_created_from_api = 0;
            $transaction->additional_notes = $this->bread_shape;
            $transaction->is_export = 0;
            $transaction->round_off_amount =0.00 ;
            $transaction->is_suspend = 0;
            $transaction->repair_updates_notif = 0;
            $transaction->save();
            $transaction_id = $transaction->id;

            TransactionSellLine::create([
                'transaction_id'=> $transaction_id,
                'product_id'=> $this->product->id,
                'variation_id'=> $variation_id, 
                'quantity'=> $this->qty,
                'mfg_waste_percent'=>0.00,
                'quantity_returned'=>0.00,
                'unit_price_before_discount'=> $variation->sell_price_inc_tax,
                'unit_price'=> $variation->sell_price_inc_tax,
                'line_discount_type'=> 'fixed',
                'unit_price_inc_tax'=> $variation->sell_price_inc_tax + ($variation->sell_price_inc_tax * $this->tax ), //impuesto en Perú falta traer el impuesto desde el sistemas
                'item_tax'=> $variation->sell_price_inc_tax * $this->tax,
                'tax_id'=> null, //en el antiguo sistema si pedia
                'so_line_id'=>null, //null en orden pero, tiene un id cuando se convierte en venta
            ]);

            $reference_pay =  $this->setAndGetReferenceCount('sell_payment');
            //registro el pago realizado por stripe
            $payment = new TransactionPayment();
            $payment->transaction_id = $transaction->id;
            $payment->business_id =  $transaction->business_id;
            $payment->amount =  $transaction->final_total;
            $payment->method ='card';
            $payment->card_type = 'credit';
            $payment->paid_on = date("Y-m-d H:i:s");
            $payment->created_by = $transaction->created_by;
            $payment->payment_for =  $transaction->contact_id;
            $payment->payment_ref_no = $reference_pay;
            $payment->save();


            \Cart::clear();
            return redirect()->route('thanks');
        }else{
            return redirect()->route('sorry');
        }
        
    }


    public function setAndGetReferenceCount($type)
    {
        $date_now = date("Y-m-d H:i:s");
        $ref = ReferenceCount::where('ref_type', $type)->where('business_id', 12)->first();
        if (! empty($ref)) {
            $ref->ref_count += 1;
            $ref->save();
            $ref_digits = str_pad($ref->ref_count, 4, 0, STR_PAD_LEFT);
            return $ref_digits;
        } else {
            return 'ERROR-'.$date_now;
        }
    }

    public function getInvoiceNumber($business_id,$invoice_scheme_id ){
        $scheme = InvoiceScheme::where('business_id', $business_id)->find($invoice_scheme_id);
        //Count
        if($scheme->number_type == 'sequential'){
            $count = $scheme->start_number + $scheme->invoice_count;
        } elseif($scheme->number_type == 'random'){
            $max = (int)str_pad(1, $scheme->total_digits, '1');
            $count = rand(1000, 9*$max);
        }

        $count = str_pad($count, $scheme->total_digits, '0', STR_PAD_LEFT);

        $scheme->invoice_count = $scheme->invoice_count + 1;
        $scheme->save();
        return $count;
    }

    public function render()
    {
        return view('livewire.add-suscription-item');
    }
}
