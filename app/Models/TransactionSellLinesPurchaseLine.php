<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSellLinesPurchaseLine extends Model
{
    use HasFactory;

    protected $fillable = ['sell_line_id','purchase_line_id','quantity'];

    public function transactions_sell_line()
    {
        return $this->belongsTo(TransactionSellLine::class);
    }
}
