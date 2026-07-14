<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // 🔒 Define which fields can be safely filled during checkout
    protected $fillable = [
        'order_id', 
        'product_id', 
        'product_name', 
        'quantity', 
        'price'
    ];

    // Link back to the parent Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Link to the Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}