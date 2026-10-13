<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    protected $fillable =[
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function order(){
        return $this->belongTo(Order::class, 'order_id');
    }

    public function product(){
        return $this->belongsTo(product::class, 'product_id');
    }
}
