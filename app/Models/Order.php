<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    use HasFactory;

    // protected $fillable = [
    //     'order_number',
    //     'order_status',
    //     'order_date',
    //     'order_time',
    // ];

    protected $fillable = ['order_status', 'total_price', 'user_id', 'created_at', 'updated_at']; // Add any other necessary fields


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
