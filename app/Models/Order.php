<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at', 'status'];
    const PENDIENTE = 1;
    const RECIBIDO = 2;
    const ENVIADO = 3;
    const TRANSITO = 4;
    const ENTREGADO = 5;
    const ANULADO = 6;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
