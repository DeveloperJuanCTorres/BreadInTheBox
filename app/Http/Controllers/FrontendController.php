<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class FrontendController extends Controller
{
    public function Home(){
        $nowMonth = Carbon::now()->format("m"); //obtener el mes actual
        $month = (int)$nowMonth; //convertir el mes de string a int
        $data['products'] = Product::whereNull('product_custom_field1')->orWhere('product_custom_field1','')->get();
        $data['breadTheMonth'] = Product::where('product_custom_field1',$month)->first();
        $data['month'] = Carbon::now()->format("F"); //Nombre del mes actual 
        //Metadata seo
        $dominio = config('app.url');
        $data['seo'] = array(
            'title'         => 'Bread in the box',
            'description'   => 'BAKERY ECOMERCE',
            'keywords'      => 'Bread,Bakery,Colorado',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('home',$data);
    }

    public function orden(){
        $data['products'] = Product::whereNull('product_custom_field1')->orWhere('product_custom_field1','')->get();
        //Metadata seo
        $dominio = config('app.url');
        $data['seo'] = array(
            'title'         => 'Bread in the box | Orden',
            'description'   => 'BAKERY ECOMERCE',
            'keywords'      => 'Bread,Bakery,Colorado',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('orden-online',$data);
    }

    public function monthlySpecialtyBreads(){
        $data['products'] = Product::whereNotNull('product_custom_field1')->where('product_custom_field1','<>','')->orderByRaw('CONVERT(product_custom_field1, INT) asc')->get();
        $nowMonth = Carbon::now()->format("m"); //obtener el mes actual
        $month = (int)$nowMonth; //convertir el mes de string a int
        $data['month'] = Carbon::now()->format("F");
        $data['months'] = ['','January','February','March','April','May','June','July','August','September','October','November','December'];
        $data['breadTheMonth'] = Product::where('product_custom_field1',$month)->first();

        //Metadata seo
        $dominio = config('app.url');
        $data['seo'] = array(
            'title'         => 'Bread in the box | Special bread of the month',
            'description'   => 'BAKERY ECOMERCE',
            'keywords'      => 'Bread,Bakery,Colorado',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('monthlySpecialtyBreads',$data);
    }

    public function about(){
        //Metadata seo
        $dominio = config('app.url');
        $data['seo'] = array(
            'title'         => 'Bread in the box | About us',
            'description'   => 'BAKERY ECOMERCE',
            'keywords'      => 'Bread,Bakery,Colorado',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('about-us',$data);
    }
    
    public function contact(){
        $dominio = config('app.url');
        $data['seo'] = array(
            'title'         => 'Bread in the box | Contact us',
            'description'   => 'BAKERY ECOMERCE',
            'keywords'      => 'Bread,Bakery,Colorado',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('contact-us',$data);
    }

    public function questions(){
        $dominio = config('app.url');
        $data['seo'] = array(
            'title'         => 'Bread in the box | Frequent questions',
            'description'   => 'BAKERY ECOMERCE',
            'keywords'      => 'Bread,Bakery,Colorado',
            'image'         => $dominio.'/images/logo-seo.png',
        );
        return view('question',$data);
    }

   

}
