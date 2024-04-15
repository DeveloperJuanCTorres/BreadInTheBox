<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Transaction;
use App\Models\TransactionSellLine;
use App\Models\TransactionPayment;
use App\Models\TransactionSellLinesPurchaseLine;
use App\Models\PurchaseLine;
use Laravel\Cashier\Exceptions\IncompletePayment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Payment;
use App\Models\InvoiceScheme;


class OrderController extends Controller
{
    public function index()
    {
        $contact = Contact::where('custom_field10', auth()->user()->id)->first();
        $orders = Transaction::query()->where('contact_id', $contact->id)->where('status','<>','completed');
        if (request('status')) {
            if(request('status') == 'Earring'){
                $orders->whereNull('shipping_status');
            }else{
                $orders->where('shipping_status', request('status'));
            }
        }
        // $orders = $orders->orderBy('id','DESC')->where('payment_status','<>','due')->get();
        // $pendiente = Transaction::whereNull('shipping_status')->where('contact_id', $contact->id)->where('status','<>','completed')->where('payment_status','<>','due')->count();
        $orders = $orders->orderBy('id','DESC')->get();
        $pendiente = Transaction::whereNull('shipping_status')->where('contact_id', $contact->id)->where('status','<>','completed')->count();
        $recibido = Transaction::where('shipping_status', 'ordered')->where('contact_id', $contact->id)->where('status','<>','completed')->count();
        $enviado = Transaction::where('shipping_status', 'packed')->where('contact_id', $contact->id)->where('status','<>','completed')->count();
        $transito = Transaction::where('shipping_status', 'shipped')->where('contact_id', $contact->id)->where('status','<>','completed')->count();
        $entregado = Transaction::where('shipping_status', 'delivered')->where('contact_id', $contact->id)->where('status','<>','completed')->count();
        $anulado = Transaction::where('shipping_status', 'cancelled')->where('contact_id', $contact->id)->where('status','<>','completed')->count();
        return view('orders.index', compact('orders', 'pendiente', 'recibido', 'enviado','transito', 'entregado', 'anulado'));
    }

    public function thanks(Transaction $transaction)
    {
        $this->authorize('author',$transaction);
        return view('thanks', compact('transaction'));
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('author',$transaction);
        $items = $transaction->transaction_sell_line;
        return view('orders.show', compact('transaction', 'items'));
    }

    public function pay(Request $request)
    {
        $date_now = date("Y-m-d H:i:s");
        $invoice_no = $this->getInvoiceNumber(12,16);
        try {
            $order = Transaction::find($request->idorder);
            $auxTotal = round($order->final_total * 100);
            $total = (int)$auxTotal;
            //PAGO POR STRIPE
            try {
                $stripeCharge =  (new User)->charge($total, $request->paymentMethod,[
                    'receipt_email' => auth()->user()->email,
                ]);
            } catch (IncompletePayment $exception) {
                return  response()->json(['status'=>false,'msg'=>"Error!!"]);
            }
            //REALIZAMOS EL CAMBIO DE ESTADO DESPUES DE PAGAR
            $order->status = 'completed';
            $order->save();
            //Almacenar el id de la orden en un array para agregarlo en el pedido por que asi lo determina el sistema comercial
            $aux = array("$order->id");
            $array_id =  json_encode($aux);
            //Crea un nuevo registro pero representando a la compra
            $transaction = $order->replicate();
            $transaction->type='sell';
            $transaction->status = 'final';
            $transaction->payment_status = 'paid';
            $transaction->invoice_no =  $invoice_no;
            $transaction->shipping_status = 'ordered';
            $transaction->sales_order_ids =  $array_id;
            $transaction->save();
            // Crea los detalles de la compra en base a los detalles de la orden 
            $products = TransactionSellLine::where('transaction_id',$request->idorder)->get();
            foreach ($products as  $product) {
                $sell_line = $product->replicate();
                $sell_line->transaction_id = $transaction->id;
                $sell_line->so_line_id = $product->id;
                $sell_line->save();
                //lista de entradad de stock
                $purchase_line = PurchaseLine::where('product_id',$product->product_id)->where('variation_id',$product->variation_id)->orderBy('id','DESC')->first();
                if($purchase_line){
                    //Registro de salidad de Stock
                    $PurchaseLine = new TransactionSellLinesPurchaseLine();
                    $PurchaseLine->sell_line_id = $product->id;
                    $PurchaseLine->quantity = $product->quantity;
                    $PurchaseLine->purchase_line_id = $purchase_line->id;
                    $PurchaseLine->save();
                }
            }
            //-----------------------------
            $payment = new TransactionPayment();
            $payment->transaction_id = $transaction->id;
            $payment->business_id =  $transaction->business_id;
            $payment->amount = ($stripeCharge->amount/100);//respuesta de stripe monto a pagar en centimos
            $payment->method ='card';
            $payment->paid_on = $date_now; 
            // $payment->card_type = $stripeCharge->payment_method_details['card']->brand; //typo de tarjeta visa o mastercar izipay
            $payment->created_by = $transaction->created_by;
            $payment->payment_for =  $transaction->contact_id;
            //$payment->payment_ref_no = $stripeCharge->id; //respuesta  stripe id de la transaccion
            $payment->save();
            return response()->json(['status'=>true,'msg'=>"We will send you an email with the details"]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>"¡¡Error!!"]);
            //throw $th;
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
}
