<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDetails extends Model
{
    use HasFactory;
    protected $table = 'orders_details';
    protected $fillable = [
        'ProductId',
        'OrderId',
        'Quantity'


    ];
    public function product()
    {
        return $this->belongsTo(Products::class, 'ProductId');
    }
    public function order()
    {
        return $this->belongsTo(OrdersProduct::class, 'OrderId');
    }
}
