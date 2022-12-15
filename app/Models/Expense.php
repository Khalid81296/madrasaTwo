<?php

namespace App\Models;

use App\User;
use Eloquent;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Expense extends Eloquent
{
    use HasFactory;

    public $table = 'expenses';

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
        'entry_month_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'created_by_id',
        'expense_category_id',
    ];

    public function expense_category(){
        return $this->hasOne(ExpenseCategory::class,'id', 'expense_category_id');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
