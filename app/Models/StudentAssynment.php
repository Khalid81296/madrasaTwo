<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssynment extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'my_class_id', 'assynment_id', 'description', 'file'


    ];
    public function user(){
        return $this->hasOne(User::class, 'id', 'student_id');
    }
    public function assynment(){
        return $this->hasOne(Assynment::class, 'id', 'assynment_id');
    }
    public function my_class(){
        return $this->hasOne(Assynment::class, 'id', 'my_class_id');
    }
}
