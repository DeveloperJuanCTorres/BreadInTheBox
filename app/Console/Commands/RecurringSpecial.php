<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;

class RecurringSpecial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generateSpecial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade special bread';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // try {
        //     ini_set('max_execution_time', 0);
        //     ini_set('memory_limit', '512M');
        //     $transactions = Transaction::where('is_recurring', 1)
        //                         ->where('type', 'sell')
        //                         ->where('status', 'final')
        //                         ->whereNull('recur_stopped_on')
        //                         ->whereNotNull('recur_interval')
        //                         ->whereNotNull('recur_interval_type')
        //                         ->with(['recurring_invoices',
        //                             'sell_lines', 'business',
        //                             'sell_lines.product', ])
        //                         ->get();
        //     foreach ($transactions as $transaction) {
        //         //inner try-catch block open
        //         try {

        //         } catch (\Exception $e) {
        //             DB::rollBack();
        //             \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
        //         }
        //     }

        // } catch (\Exception $e) {
        //     \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
        //     exit($e->getMessage());
        // }
    }
}
