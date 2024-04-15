<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Transaction;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Anular pedidos';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        // $timestamp = Carbon::now()->subMinute(30);
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
       
    }
}
