<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BadrinPaymentRecord extends Eloquent
{
    protected $fillable = ['badrin_id', 'amt_paid', 'entry_date', 'month_id',  'year'];

    public function badrin()
    {
		return $this->belongsTo(User::class);
    }
}
