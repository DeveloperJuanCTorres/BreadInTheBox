<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded  = ['id','contact_id','created_at','updated_at'];
    public function transaction_sell_line()
    {
        return $this->hasMany(TransactionSellLine::class);
    }

    public function subscription_invoices()
    {
        return $this->hasMany(Transaction::class, 'recur_parent_id');
    }

    public function transaction_payment()
    {
        return $this->hasMany(TransactionPayment::class);
    }  
    
    //funcion que permite ver la proxima factura que se generará (cuenta las facturas generadas y suma la fecha del intervalo)
    public function nextInvoices(){
        if (empty($this->recur_stopped_on)) {
            $last_generated = ! empty(count($this->subscription_invoices)) ? Carbon::parse($this->subscription_invoices->max('transaction_date')) : Carbon::parse($this->transaction_date);
            $last_generated_string = $last_generated->format('Y-m-d');
            $last_generated = Carbon::parse($last_generated_string);
            if ($this->recur_interval_type == 'days') {
                $aux_invoice = $last_generated->addDays($this->recur_interval);
                //le sumo 1 dia por que se reparte un dia despues de la facturacion 
                $upcoming_invoice = $aux_invoice->addDay();
            }
        }
        return ! empty($upcoming_invoice) ? $this->format_date($upcoming_invoice) : '';
    }

    public function format_date($date)
    {
        return ! empty($date) ? Carbon::createFromTimestamp(strtotime($date))->format('m-d-Y') : null;
    }

}
