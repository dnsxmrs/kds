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

    // protected $fillable = [
    //     'order_status'
    //     , 'total_price'
    //     , 'user_id'
    //     , 'created_at'
    //     , 'updated_at'
    // ]; // Add any other necessary fields

    protected $fillable = [
        'order_id',
        'order_number',
        'order_status',
        // 'order_type',
        'order_date',
        'order_time',
        'note',
        'origin',
        'updated_at',
        'created_at',
        // Add any other fields that need mass assignment
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
