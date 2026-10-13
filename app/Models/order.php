<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $fillable = [
        'total_price',
        'total_item',
        'payment_amount',
        'cachier_id',
        'cashier_name',
        'payment_method',
        'transaction_time'
    ];

    public function cashier(){
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
