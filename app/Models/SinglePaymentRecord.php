<?php

namespace App\Models;

use App\User;
use Eloquent;

class SinglePaymentRecord extends Eloquent
{
    protected $fillable =['student_id', 'my_class_id', 'payment_id', 'amt_paid', 'year', 'paid', 'balance', 'ref_no'];
    
    public function singlePayment()
    {
        return $this->belongsTo(SinglePayment::class, 'payment_id', 'id' );
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function singleReceipt()
    {
        return $this->hasMany(SingleReceipt::class, 'single_payment_records_id');
    }
}
