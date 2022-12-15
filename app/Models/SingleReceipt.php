<?php

namespace App\Models;

use App\User;
use Eloquent;

class SingleReceipt extends Eloquent
{
    protected $fillable = ['year', 'single_payment_records_id', 'balance', 'amt_paid'];
    public function pr()
    {
        return $this->belongsTo(SinglePaymentRecord::class, 'single_payment_records_id');
    }

}
