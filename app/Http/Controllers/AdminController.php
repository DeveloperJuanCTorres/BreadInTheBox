<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Mail\ContactUs;
use App\Models\Variation;

class AdminController extends Controller
{
   
    public function menssage(Request $request)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify',[
            'secret'=>'6LfOl4spAAAAAEiSIhMJVczhJWV5yMHRvTmDJ9xF',
            'response'=>$request->g_recaptcha_response,
        ])->object();

        if($response->success && $response->score >=0.7){
            $correo = new ContactUs($request);
            try {
                Mail::to('customer@breadinthebox.com')->send($correo);
                return response()->json(['status' => true, 'msg' => "Your message was sent successfully"]);
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'msg' => "An error occurred!!, try again later"]);
            }
        }else{
            return response()->json(['status' => true, 'msg' => "La verificación de ReCaptcha ha fallado"]);
        } 
    }

    public function addPack(Request $request){
        try {
            $product = Product::where('id',$request->id)->first();
            $variation = Variation::where('id',$request->variation)->first();
            \Cart::add([
                'id' => $request->id.'-'.$request->variation,
                'name' => $product->name,
                'price' => $request->price,
                'quantity' => 1,
                'attributes' => array(
                    'image' => 'img/'.$product->image,
                    'product_id' => $product->id,
                    'variante' => $variation->name,
                    'variation_id'=> $variation->id,
                ),
            ]);
    
            return response()->json(['status' => true, 'msg' => "The package was added to the cart"]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => "Error!!,Something went wrong!!"]);
        }
    }

    public function conditions()
    {
        $dominio = config('app.url');
        $data['seo'] = array(
            'title'         => 'Bread in the box | Terms and conditions',
            'description'   => 'bread,Denver',
            'keywords'      => 'bread',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('conditions',$data);
    }

}
