<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'file', 'user_id'

    ];
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
