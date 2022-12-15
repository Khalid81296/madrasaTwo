<?php

namespace App;

use App\Models\BloodGroup;
use App\Models\District;
use App\Models\Division;
use App\Models\Lga;
use App\Models\Nationality;
use App\Models\Salary;
use App\Models\StaffRecord;
use App\Models\State;
use App\Models\StudentRecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'father', 'occupation', 'sup_teacher', 'present_address', 'username', 'email', 'phone', 'phone2', 'dob', 'gender', 'photo', 'address', 'bg_id', 'password', 'nal_id', 'state_id', 'lga_id', 'code', 'user_type', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function student_record()
    {
        return $this->hasOne(StudentRecord::class);
    }
    public function salaries()
    {
        return $this->hasOne(Salary::class, 'user_id', 'id');
    }

    // public function lga()
    // {
    //     return $this->belongsTo(Lga::class);
    // }

    // public function state()
    // {
    //     return $this->belongsTo(State::class);
    // }
    public function lga()
    {
        return $this->belongsTo(District::class,'lga_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo(Division::class, 'state_id', 'id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nal_id');
    }

    public function blood_group()
    {
        return $this->belongsTo(BloodGroup::class, 'bg_id');
    }

    public function staff()
    {
        return $this->hasMany(StaffRecord::class);
    }
}
