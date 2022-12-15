<?php

namespace App\Models;

use App\User;
use Eloquent;
use App\Models\IncomeCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Income extends Eloquent
{
    use HasFactory;

    public $table = 'incomes';

    protected $dates = [
        'entry_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'amount',
        'entry_date',
        'entry_year',
        'mobile_no',
        'entry_month_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'created_by_id',
        'income_category_id',
    ];
    
    public function income_category(){
        return $this->hasOne(IncomeCategory::class,'id', 'income_category_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
