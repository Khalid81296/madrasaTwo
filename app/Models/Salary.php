<?php

namespace App\Models;

use App\User;
use Eloquent;

class Salary extends Eloquent
{
    protected $fillable = [
        'id', 'user_id', 'amount', 'designation', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
