<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Variation;
use App\Models\Media;

class AddCartItem extends Component
{

    protected $listeners = ['addItem'];
    public $product, $quantity, $image = '';
    public $pdf;
    public $variation_id, $variation, $variationes, $is_active = false;
    public $qty = 1;
    public $precio = 0;
    public $bread_shape="";
    public $option = [
        'variation_id'=>null,
        'variante' => null,
        'image' => null,
        'product_id'=>null,
        'bread_shape'=>'',
    ];

    public function mount()
    {
        $this->pdf = Media::where('model_id',$this->product->id)->where('model_type','App\Product')->first();
        $this->image = 'img/'.$this->product->image;
        $this->option['image'] = 'img/'.$this->product->image;
        $this->option['product_id'] = $this->product->id;
        $this->variation = Variation::where('product_id',$this->product->id)->first();
        $this->precio =  $this->variation->sell_price_inc_tax;
        $this->option['variante'] = $this->variation->name;
        $this->variation_id = $this->variation->id;
        $this->option['variation_id'] = $this->variation_id;
        $this->variationes = Variation::where('product_id',$this->product->id)->get();
        if($this->variationes->count() > 1){
            $this->is_active = true;
        }
        // $this->quantity = qty_available($this->product->id, $this->variation_id); 
        $this->quantity = 50;
    }

    // public function updatedVariationId($value)
    // {
        
    //     $this->variation = Variation::find($value);
    //     $image = Media::where('model_id',$this->variation->id)->first();
    //     $this->image = 'media/'.$image->file_name;
    //     $this->option['image'] = 'media/'.$image->file_name;


    //     $this->variation_id = $value;
    //     $this->option['variation_id'] = $this->variation_id;
    //     $this->option['variante'] = $this->variation->name; 
    //     $this->precio = $this->variation->sell_price_inc_tax;
        // $this->quantity = qty_available($this->product->id, $this->variation_id); 
    // }

    public function decrement(){
        $this->qty = $this->qty -1;
    }

    public function incrementar(){
        $this->qty = $this->qty +1;
    }

    public function addItem(){

        $this->option['bread_shape'] = $this->bread_shape;
        
        \Cart::add([
            'id' => $this->product->id.'-'.$this->variation_id,
            'name' => $this->product->name,
            'price' => $this->precio,
            'quantity' => $this->qty,
            'attributes' => $this->option,
        ]);

        // $this->quantity =  qty_available($this->product->id, $this->variation_id); 
        $this->reset('qty');
        $this->emitTo('header','render');
    }

    public function render()
    {
        return view('livewire.add-cart-item');
    }
}
