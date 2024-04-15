<?php

namespace App\Http\Livewire;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Contact;
use App\Models\Transaction;
use App\Models\TransactionSellLine;
use App\Models\TaxRate;
use App\Models\ReferenceCount;
use Carbon\Carbon;
use App\Models\InvoiceScheme;

class CreateOrder extends Component
{
    public $listeners = ['create_order'];

    public $contact = null, $address, $envio_type = 1;
    public $shipping_cost = 0;
    public $zip_code="", $references="";
    public $isActive=true;
    public $tax = 0, $tax_cost;
    public $startDay, $day, $dateSelected, $description;

    public function mount(){
        $taxRate = TaxRate::where('name','Colorado')->first();
        $this->tax_cost  =\Cart::getSubTotal() * ($taxRate->amount/100);
        $delivery = TaxRate::where('name','delivery')->first();
        $this->tax = ($taxRate->amount/100);
        $this->contact = Contact::where('custom_field10',Auth::user()->id)->first();
        if(\Cart::getSubTotal() < 25)
        $this->shipping_cost = $delivery->amount;

        $this->slicedBread();
    }

    public function slicedBread(){
        $items = \Cart::getContent();;
        foreach($items as $item){
            if($item->attributes->bread_shape == 'Sliced'){
                $this->description .= "".$item->name." has to be sliced.";
            }
        }
    }

    public function create_order(){

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
            'day.between'=>'Deliveries are only Monday and Tuesday',
            'day.required'=>'You have to select a day'
        ];

        $rules['dateSelected'] = 'required';
        $rules['day'] = 'required|integer|between:1,2';

        if($this->envio_type == 2){
            $messages = [
                'district_id.required'=>'You have to select a zip code',
                'address.required'=>'You have to enter an address',
            ];
            $rules['zip_code'] = 'required';
            $rules['address'] = 'required';
            $this->address =  $this->address.' (CO, Denver, '.$this->zip_code.') ';
        }else{
            $this->address = $this->contact->address_line_1 .' ('.$this->contact->state.', '.$this->contact->city.', '.$this->contact->zip_code.')';
        }

        $this->validate($rules,$messages);

        if(!$this->isActive){
            return false;
         }
 

        $date_now = date("Y-m-d H:i:s");
        // $reference  =  $this->setAndGetReferenceCount('sell_payment'); 
        $delivery_date = Carbon::parse($this->startDay)->format('Y-m-d H:i:s');
        $invoice_no = $this->getInvoiceNumber(12,16);
        // -----Crear la orden de compra------
        $transaction = new Transaction();
        $transaction->business_id = 12;
        $transaction->location_id = 12;
        $transaction->status = 'ordered' ;
        $transaction->type = 'sales_order';
        $transaction->res_waiter_id = 17; // cambiar 2 que sera la Ecommerce vendedor
        $transaction->contact_id = $this->contact->id;
        $transaction->shipping_address = $this->address;
        $transaction->shipping_details = $this->references;
        $transaction->delivered_to = $this->contact->supplier_business_name.''.$this->contact->first_name.' '.$this->contact->last_name;
        $transaction->delivery_date = $delivery_date;
        $transaction->shipping_custom_field_1 = $this->contact->mobile;
        $transaction->discount_type = 'percentage';
        $transaction->recur_interval = 1.00;
        $transaction->recur_interval_type = 'days';
        $transaction->pay_term_type = 'months';
        $transaction->transaction_date = $date_now;
        $transaction->total_before_tax = \Cart::getSubTotal();
        $transaction->tax_amount = $this->tax_cost;
        $transaction->rp_redeemed = 0;
        $transaction->rp_redeemed_amount = 0.00;
        $transaction->shipping_charges = $this->shipping_cost;//costo de envio
        $transaction->additional_notes = $this->description;
        
        $transaction->is_export = 0;
        $transaction->round_off_amount =0.00 ;
        $transaction->final_total = \Cart::getSubTotal() + $this->shipping_cost  + $this->tax_cost; //total mas envio 
        $transaction->is_direct_sale = 1 ;
        $transaction->is_suspend = 0;
        $transaction->exchange_rate = 1.00 ;
        $transaction->created_by = 65; //ID del Ecommerce como vendedor
        $transaction->mfg_production_cost = 0.00 ;
        $transaction->mfg_is_final = 0;
        $transaction->repair_updates_notif = 0;
        $transaction->is_created_from_api = 0;
        $transaction->rp_earned = 0;
        $transaction->is_recurring = 0;
        $transaction->invoice_no = $invoice_no;
        $transaction->custom_field_4 = 'ecommerce'; //Variable opcional que sirve para identificar el ecommerce
        $transaction->service_custom_field_6 = \Cart::getContent();
         //agregué para el nuevo sistema
        $transaction->essentials_duration = 0;
        $transaction->essentials_amount_per_unit_duration = 0;
        //------------
        $transaction->save();
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
            // discount($item);
         }
        //----------------
        \Cart::clear();
        return redirect()->route('orders.payment', $transaction);
    }

    public function itemCart()
    {
        $cant = 0;
        $items = \Cart::getContent();
        foreach ($items as $row) {
            $cant = $cant + $row->quantity;
        }
        return $cant;
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

    // public function setAndGetReferenceCount($type)
    // {
    //     $date_now = date("Y-m-d H:i:s");
    //     $ref = ReferenceCount::where('ref_type', $type)->where('business_id', 12)->first();
    //     if (! empty($ref)) {
    //         $ref->ref_count += 1;
    //         $ref->save();
    //         $ref_digits = str_pad($ref->ref_count, 4, 0, STR_PAD_LEFT);
    //         return $ref_digits;
    //     } else {
    //         return 'error-'.$date_now;
    //     }
    // }

    public function render()
    {
        $dominio = config('app.url');
        $seo = array(
            'title'         => 'Bread in the box | Checkout',
            'description'   => 'BAKERY ECOMERCE',
            'keywords'      => 'Bread,Bakery,Colorado',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('livewire.create-order',compact('seo'));
    }

}