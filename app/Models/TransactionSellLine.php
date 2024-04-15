<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSellLine extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function transactions_sell_lines_purchase_line()
    {
       return $this->hasMany(transactions_sell_lines_purchase_line::class);
    }



}
