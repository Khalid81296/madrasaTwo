<?php

namespace App\Models;

use App\User;
use Eloquent;

class OtherPayment extends Eloquent
{
    protected $fillable = [
        'id', 
        'name', 
        'email', 
        'user_id', 
        'created_by', 
        'created_at', 
        'updated_at', 
        'description',
        'amount',
        'method',
        'payment_type_id'
    ];

    public function paymentType()
    {
        return $this->hasOne(PaymentType::class, 'id', 'payment_type_id');
    }

}
