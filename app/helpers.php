<?php
use App\Models\Product;
use App\Models\VariationLocationDetails;

function quantity($product_id,$variation_id)
{
    $quantity = VariationLocationDetails::where('product_id',$product_id)->where('variation_id',$variation_id)->first();
    if($quantity){
        return $quantity->qty_available;
    }else{
        return 0;
    }

}

function qty_added($variation_id)
{
    $cart = \Cart::getContent();
    $item = $cart->where('attributes.variation_id',$variation_id)->first();
    if($item){
        return $item->quantity;
    }else{
        return 0;
    }
}

function qty_available($product_id,$variation_id)
{
    return quantity($product_id,$variation_id) - qty_added($variation_id);
}

function discount($item){
    $qty_available = qty_available($item->attributes->product_id, $item->attributes->variation_id);
    $quantity = VariationLocationDetails::where('product_id',$item->attributes->product_id)->where('variation_id',$item->attributes->variation_id)->first();
    $quantity->qty_available = $qty_available;
    $quantity->save();
}

function increase($item){
    $variation_detail = VariationLocationDetails::where('product_id',$item->attributes->product_id)->where('variation_id',$item->attributes->variation_id)->first();
    $qty_available = quantity($item->attributes->product_id, $item->attributes->variation_id) + $item->quantity;
    $variation_detail->qty_available = $qty_available;
    $variation_detail->save();
}
