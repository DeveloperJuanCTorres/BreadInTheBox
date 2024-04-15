<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TaxRate;
use App\Models\TransactionSellLine;
use App\Models\ReferenceCount;
use Carbon\Carbon;
use Laravel\Cashier\Exceptions\IncompletePayment;
use App\Models\User;
use App\models\TransactionPayment;
use App\Models\InvoiceScheme;
use App\Models\Product;

class AddSuscriptionCart extends Component
{

    public $listeners = ['suscription_cart'];
    public $contact = null;
    public $frequency = "", $references;
    public $startDay, $day,$dateSelected;
    public $tax, $tax_cost, $shipping_cost, $total,$taxRate;
    public $price = 0, $descriptio;

    public function mount(){
        $this->contact = Contact::where('custom_field10',Auth::user()->id)->first();
        //-----------------
        $this->taxRate = TaxRate::where('name','Colorado')->first();
        $this->tax_cost  =\Cart::getSubTotal() * ($this->taxRate->amount/100);
        $delivery = TaxRate::where('name','delivery')->first();
        $this->tax = ($this->taxRate->amount/100);
        $this->contact = Contact::where('custom_field10',Auth::user()->id)->first();
        if(\Cart::getSubTotal() < 25)
        $this->shipping_cost = $delivery->amount;
        $this->slicedBread();
        // $this->searchBreadSpecial();
    }

    public function slicedBread(){
        $items = \Cart::getContent();
        foreach($items as $item){
            if($item->attributes->bread_shape == 'Sliced'){ 
                $this->descriptio .= " ".$item->name." has to be sliced. ";
            }
        }
    }

    public function searchBreadSpecial(){
        $items = \Cart::getContent();
        foreach ($items as $key => $item) {
            $product = Product::find($item->attributes->product_id);
            if(empty($product->product_custom_field1)){
                $this->type = "simple";
            }else{
                $this->type = "special";
                break;
            }
        }
    }

    public function suscription_cart(){
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
        $total = \Cart::getSubTotal() + $this->shipping_cost  + $this->tax_cost; //total mas envio 
        $auxTotal = round($total * 100);
        $totalStripe = (int)$auxTotal;

        try {
            $user = User::find(auth()->user()->id);
            $user->charge($totalStripe,$user->idPaymentMethod);  
            $isPaid = true;

        } catch (IncompletePayment $exception) {
            $isPaid =  false;
        }
        //------------------------
        if($isPaid){
            $form_date = Carbon::parse($this->startDay)->subDay()->format('Y-m-d H:i:s');  //fecha seleccionada en datepiker con un dia menos para que el Job lo genere un dia antes
            $delivery_date = Carbon::parse($this->startDay)->format('Y-m-d H:i:s');
            $reference  =  $this->setAndGetReferenceCount('subscription');
            //12 es el ID del  negocio y 16 es el correlativo de las facturas;
            $invoice_no = $this->getInvoiceNumber(12,16);
            $anio = date("Y");

            $transaction = new Transaction();
            $transaction->business_id = 12;
            $transaction->location_id = 12;
            $transaction->type = 'sell';
            $transaction->status = 'final';
            $transaction->payment_status = 'paid'; //*cambio
            $transaction->contact_id = $this->contact->id;
            $transaction->invoice_no =  $invoice_no; //Numero de Referencia
            $transaction->subscription_no =  $anio.'-'.$reference; //Numero de referencia de la suscription
            $transaction->transaction_date = $form_date;//guardo la fecha con un dia menos 
            $transaction->total_before_tax =  \Cart::getSubTotal();
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
            $transaction->shipping_charges =  $this->shipping_cost;//costo de envio
            $transaction->shipping_custom_field_1 = $this->contact->mobile;
            $transaction->final_total = $total;//total mas envio 
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
            $transaction->additional_notes = $this->descriptio;
            $transaction->is_export = 0;
            $transaction->round_off_amount =0.00 ;
            $transaction->is_suspend = 0;
            $transaction->repair_updates_notif = 0;
            $transaction->service_custom_field_6 = \Cart::getContent();
            $transaction->save();
            //---------------------------
            $transaction_id = $transaction->id;
            foreach (\Cart::getContent() as $item) {
                //las variacion se tienen que agegar en el momendo de agregar e el producto
                TransactionSellLine::create([
                    'transaction_id'=> $transaction_id,
                    'product_id'=> $item->attributes->product_id,
                    'variation_id'=> $item->attributes->variation_id, 
                    'quantity'=> $item->quantity,
                    'mfg_waste_percent'=>0.00,
                    'quantity_returned'=>0.00,
                    'unit_price_before_discount'=> $item->price,
                    'unit_price'=> $item->price,
                    'line_discount_type'=> 'fixed',
                    'unit_price_inc_tax'=> $item->price + ($item->price * $this->tax ), //impuesto en Perú falta traer el impuesto desde el sistemas
                    'item_tax'=> $item->price * $this->tax,
                    'tax_id'=> null, //en el antiguo sistema si pedia
                    'so_line_id'=>null, //null en orden pero, tiene un id cuando se convierte en venta
                ]);
            }

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
        return view('livewire.add-suscription-cart');
    }
}
