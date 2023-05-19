<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{

    use HasFactory;
    protected $fillable = [
        'id',
        'NameProducts',
        'Details',
        'Price',
        'Stock',
        'isSeller',
        'image',
        'CateId',
        'created_at',
        'updated_at',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'id');
    }
}
