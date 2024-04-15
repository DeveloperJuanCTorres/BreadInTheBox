<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];
    //Scope gloval para filtrar la empresa con el ID = 4 en todas las consultas
    protected static function booted()
    {
        static::addGlobalScope('only_bussines',function(Builder $builder){
            $builder->where('business_id',12)->where('is_inactive',0);
        });
    }
    
    //relacion uno a muchos inversa
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //relacion uno a muchos
    public function variation(){
        return $this->hasMany(Variation::class);
    }

    //relacion uno a muchos inversa
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    //relacion con unidad de medida
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function transaction_sell_line()
    {
        return $this->hasMany(TransactionSellLine::class);
    }

    //URL AMIGABLE

    public function getRouteKeyName()
    {  
        return 'sku';
    }
    // public function getRouteKeyName()
    // {  
    //     return 'product_custom_field5';
    // }
}
