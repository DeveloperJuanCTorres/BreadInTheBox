<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CmsPages;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product){
        
        $rules = [
            'comment'=>"required|min:5",
            'rating'=>'required|integer|min:1|max:5'
        ];

        $messages = [
            'comment.required' => 'Tienes que escribir un comentario',
            'comment.max' =>'Tiens que escribir minimo 5 caracteres',
            'rating.min' => 'Tienes que dejar una calificación de estrella'
        ];

        $this->validate($request,$rules,$messages);
        $product->reviews()->create([
            'comment'=> $request->comment,
            'rating' => $request->rating,
            'user_id' => auth()->id(),
        ]);

        session()->flash('flash.banner', 'Tu comentario fue añadida con éxito');
        session()->flash('flash.bannersStyle','success');
        return redirect()->back();
        // return $request->all();
    }


    public function blog(Request $request, CmsPages $note){
        
        $rules = [
            'comment'=>"required|min:5",
        ];

        $messages = [
            'comment.required' => 'Tienes que escribir un comentario',
            'comment.max' =>'Tiens que escribir minimo 5 caracteres',
        ];

        $this->validate($request,$rules,$messages);
        $note->reviews()->create([
            'comment'=> $request->comment,
            'rating' => 5,
            'user_id' => auth()->id(),
        ]);

        session()->flash('flash.banner', 'Tu comentario fue añadida con éxito');
        session()->flash('flash.bannersStyle','success');
        return redirect()->back();
    
    }
}
