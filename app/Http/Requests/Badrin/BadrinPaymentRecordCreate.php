<?php

namespace App\Http\Requests\Badrin;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Qs;

class BadrinPaymentRecordCreate extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'badrin_id' => 'required',
            'entry_date' => 'required',
            'amt_paid' => 'required',
            'year' => 'required',
            'month_id' => 'required',
        ];
    
    }

    // protected function getValidatorInstance()
    // {
    //     $input = $this->all();

    //     $input['my_parent_id'] = $input['my_parent_id'] ? Qs::decodeHash($input['my_parent_id']) : NULL;

    //     $this->getInputSource()->replace($input);

    //     return parent::getValidatorInstance();
    // }
}
