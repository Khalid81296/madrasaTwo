<?php

namespace App\Models;

use App\User;
use Eloquent;

class ExpensType extends Eloquent
{
    protected $fillable = [
        'id', 'name', 'status', 'created_at', 'created_by'
    ];
}
