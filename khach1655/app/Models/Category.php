<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'Category';
    protected $fillable = [
        'id',
        'CateName',
        'Details',
        'image',
        'created_at',
        'updated_at',
    ];
    public function products()
    {
        return $this->hasMany(Products::class, 'CateId');
    }
}
