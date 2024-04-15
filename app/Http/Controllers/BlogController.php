<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\CmsPages;

class BlogController extends Controller
{
    public function index(){
        $notes = CmsPages::Status()->Type('blog')->paginate(5);
        $relacionadas = CmsPages::Status()->Type('blog')->inRandomOrder()->limit(10)->get();

        $seo = array(
            'title'         => 'Blog - Bread in the box',
            'description'   => 'E-commerce de repuesto y lubricantes para maquinaria pesada, Cargadores, Tractocamiones,Excabadoras, Minicargadores,Volquetes,XCMG,Perú,Tumbes',
            'keywords'      => 'XCMG,repuestos,perú,tumbes,cargadores,tractocamiones,excabadoras,minicargadores,lubricantes,',
        );

        return view('blog',compact('notes','relacionadas','seo'));
    }
    
    public function show(Request $request){
        $id = last(explode('-', $request->url()));
        $note = CmsPages::Status()->Type('blog')->findOrFail($id);
        $relacionadas = CmsPages::Status()->Type('blog')->inRandomOrder()->limit(10)->get();
        $tags = $array = explode(",", $note->tags);

        $seo = array(
            'title'         =>  $note->title.' | Bread in the box',
            'description'   => $note->meta_description,
            'keywords'      => $note->tags,
        );

        return view('blog-detail')->with(compact('note','relacionadas','tags','seo'));
    }
}
