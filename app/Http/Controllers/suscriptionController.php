<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Laravel\Cashier\Cashier;
use PhpParser\Builder\Trait_;

class suscriptionController extends Controller
{

    public function show(Transaction $transaction)
    {
        $this->authorize('author',$transaction);
        $items = $transaction->transaction_sell_line;
        return view('suscription.show', compact('transaction', 'items'));
    }

    public function edit(Transaction $transaction){
        $this->authorize('author',$transaction);
        $items = $transaction->transaction_sell_line;
        return view('suscription.edit', compact('transaction', 'items'));
    }

    public function create(Product $product) {
        $dominio = config('app.url');
        $seo = array(
            'title'         => 'Bread in the box | Subscription',
            'description'   => 'bread,Denver',
            'keywords'      => 'bread',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('suscription.suscribeProduct',compact('product','seo'));
    }

    public function cart(){

        $dominio = config('app.url');
        $data['seo'] = array(
            'title'         => 'Bread in the box | Subscription',
            'description'   => 'bread,Denver',
            'keywords'      => 'bread',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('suscription.suscribeCart',$data);
    }

    public function registerCard(Request $request){
        try {
            $PaymentMethod = auth()->user()->addPaymentMethod($request->setupIntent);

            DB::table('users')->where('id',auth()->user()->id)->update([
                'idPaymentMethod' => $PaymentMethod->id,
            ]);
            return response()->json(['status'=>true,'msg'=>'Se ha registrado la tarjeta correctamente']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>false,'msg'=>'Error al registrar la tarjeta']);
        }
    }

    public function removeCard(Request $request){
        try {
            $paymenthMethod =  auth()->user()->findPaymentMethod($request->id);
            $paymenthMethod->delete();
            DB::table('users')->where('id',auth()->user()->id)->update([
                'idPaymentMethod' => '',
            ]);
            return response()->json(['status' => true, 'msg' => "Card remove successfully"]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => "An error occurred, please try again later!"]);
        }
    }

    public function thanks(){
        return view('suscription.thanks');
    }

    public function sorry(){
        return view('suscription.sorry');
    }

}
