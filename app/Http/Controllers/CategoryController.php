<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $seo = array(
            'title'         => $category->name,
            'description'   => 'E-commerce de repuesto y lubricantes para maquinaria pesada, Cargadores, Tractocamiones,Excabadoras, Minicargadores,Volquetes,XCMG,Perú,Tumbes',
            'keywords'      => 'XCMG,repuestos,perú,tumbes,cargadores,tractocamiones,excabadoras,minicargadores,lubricantes,',
        );
       return view('categories.show',compact('category','seo'));
    }

    public function showCategory(){
        return view('products.listCategory');
    }
}
