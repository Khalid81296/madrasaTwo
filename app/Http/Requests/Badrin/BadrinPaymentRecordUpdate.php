<?php

namespace App\Http\Requests\Badrin;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Qs;

class BadrinPaymentRecordUpdate extends FormRequest
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
            'amt_paid' => 'required',
            'year' => 'required',
            'month_id' => 'required',
        ];
    }

    /*public function attributes()
    {
        return  [
            'nal_id' => 'Nationality',
            'dorm_id' => 'Dormitory',
            'state_id' => 'State',
            'lga_id' => 'LGA',
            'bg_id' => 'Blood Group',
            // 'my_parent_id' => 'Parent',
            'my_class_id' => 'Class',
            'member_no' => 'Member No',
            'section_id' => 'Section',
        ];
    }*/

    /*protected function getValidatorInstance()
    {
        $input = $this->all();

        $input['my_parent_id'] = $input['my_parent_id'] ? Qs::decodeHash($input['my_parent_id']) : NULL;

        $this->getInputSource()->replace($input);

        return parent::getValidatorInstance();
    }*/
}
