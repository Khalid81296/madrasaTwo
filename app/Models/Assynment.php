<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assynment extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'file',
        'user_id',
        'my_class_id',
        'teacher_id',
        'subject_id',
        'sub_date',
        'class_sec_id'
    ];
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function my_class(){
        return $this->hasOne(MyClass::class, 'id', 'my_class_id');
    }
    public function subject(){
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
}
