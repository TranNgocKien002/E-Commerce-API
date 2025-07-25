<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
      // Cho phép các trường này được gán hàng loạt
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];
}
