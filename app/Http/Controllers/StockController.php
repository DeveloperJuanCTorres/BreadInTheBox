<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\VariationLocationDetails;
use App\Models\Transaction;

class StockController extends Controller
{
    public function clean(){

        $timestamp = Carbon::now()->subMinute(30);
        $date = Carbon::parse($timestamp)->format('Y-m-d');
        $time = Carbon::parse($timestamp)->toTimeString();
        $transactions = Transaction::whereNotNull('service_custom_field_6')->where('custom_field_4','ecommerce')->where('status','ordered')->whereDate('created_at',$date)->whereTime('created_at', '<=', $time)->get();
       
        foreach ($transactions as $transaction) {
            $items =  json_decode($transaction->service_custom_field_6);
            foreach ($items as $item) {
                increase($item);
            }
            $transaction->delete();
        }
        return "Ordenes Canceladas";
    }
}
