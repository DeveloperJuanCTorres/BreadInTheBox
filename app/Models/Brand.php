<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\Builder;
class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    //Scope gloval para filtrar la empresa con el ID = 4 en todas las consultas
    protected static function booted()
    {
        static::addGlobalScope('only_bussines',function(Builder $builder){
            $builder->where('business_id',12);
        });
    }

    //Relacion uno a muchos
    public function products(){
        return $this->hasMany(Product::class);
    }

    //Relacion muchos a muchos
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
