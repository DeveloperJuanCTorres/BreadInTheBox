<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Media;
use App\Models\CmsPages;


class ProductController extends Controller
{
    public function show(Product $product){
        //producto recomendados
        $products = Product::whereNull('product_custom_field1')->orWhere('product_custom_field1','')->get();
        //metadata seo
        $dominio = config('app.url');
        $seo = array(
            'title'         => $product->name.' | Bread in the box',
            'description'   => 'BAKERY ECOMERCE',
            'keywords'      => 'Bread,Denver'.$product->name,
        );
        return view('products.show', compact('product','seo','products'));
    }
}
