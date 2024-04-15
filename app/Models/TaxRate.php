<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\Builder;

class TaxRate extends Model
{
    use HasFactory;
    protected $fillable = ['name','amount'];

  
     protected static function booted()
     {
         static::addGlobalScope('only_bussines',function(Builder $builder){
             $builder->where('business_id',12);
         });
     }
 
}
