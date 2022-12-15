<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsManagement extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'user_id'

    ];
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
