<?php

namespace App\Models;

use App\User;
use Eloquent;

class PaymentType extends Eloquent
{
    protected $fillable = ['id', 'name', 'status', 'description'];

    public function pr()
    {
        return $this->belongsTo(PaymentRecord::class, 'pr_id');
    }

}
