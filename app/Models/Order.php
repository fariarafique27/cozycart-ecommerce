<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'customer_email', 'shipping_address', 'total_amount', 'status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    //the orders table has a column named user_id.
    //  When I ask for an order's user, go use that ID to find the matching
    //  row in the users table.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}