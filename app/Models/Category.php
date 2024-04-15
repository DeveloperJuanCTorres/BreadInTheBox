<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; 

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];
    //Scope gloval para filtrar la empresa con el ID = 4 en todas las consultas
    protected static function booted()
    {
        static::addGlobalScope('only_bussines',function(Builder $builder){
            $builder->where('business_id',12);
        });
    }

    //relacion de uno a muchos
    public function products(){
        return $this->hasMany(Product::class)->where("business_id",12);
    }

    //URL AMIGABLE
    public function getRouteKeyName()
    {  
        return 'slug';
    }
}
