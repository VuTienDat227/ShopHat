<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
class OrdersProduct extends Model
{
    use HasFactory;
    protected $table = 'orders_products';
    protected $fillable = [
        'id',
        'Status',
        'StatusForAdmin',
        'isCheck',
        'user_id',
        'TotalPay'

    ];
    public function product()
    {
        return $this->belongsTo(Products::class, 'ProductId');
    }
    public function user()
    {
        return $this->belongsTo(UserLogin::class, 'user_id')->select(['id', 'UserName', 'FullName', 'PhoneNumber','Address','Email']);
    }
    public function order()
    {
        return $this->hasMany(OrdersDetails::class, 'OrderId');
    }


}
