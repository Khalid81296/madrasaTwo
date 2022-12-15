<?php

namespace App\Http\Requests;

use App\Models\Income;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;


class StoreIncomeRequest extends FormRequest
{
    public function authorize()
    {
       return true;
    }

    public function rules()
    {
        return [
            'income_category_id' => [
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
            'mobile_no'     => [
                'required',
            ],
        ];
    }
}
