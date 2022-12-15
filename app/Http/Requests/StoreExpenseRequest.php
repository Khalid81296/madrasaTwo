<?php

namespace App\Http\Requests;

use App\Expense;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'expense_category_id' => [
                'required',
                
            ],
            'entry_date' => [
                'required',
                
            ],
            'amount'     => [
                'required',
            ],
            'entry_month_id'     => [
                'required',
            ],
        ];
    }
}
