<?php

namespace Modules\FileManagement\Http\Requests\Forms\AFL;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\HumanResource\Entities\HR_Employee;

class AFLStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $hrtable = HR_Employee::getTableName();

        return [
            'employee'      =>  ['required', Rule::exists($hrtable, 'id')],
            'leave_type'    => 'required',
            'inclusive'     => 'required',
            'caf'           => 'required',
            'v1'            => 'required',
            's1'            => 'required',
            'v2'            => 'required',
            's2'            => 'required',
            'approval'      => ['required', 'integer', Rule::exists($hrtable, 'id')],
            'hr'            => ['required', 'integer', Rule::exists($hrtable, 'id')],
            'liaison'       => ['required', 'integer', Rule::exists($hrtable, 'id')->where('liaison', 1)]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [

            'inclusive.required' => 'Inclusive dates are required.',
            'caf.required' => 'The field Certified As Of is required.',

            'v1.required' => 'The first vacation entry is required.',
            'v2.required' => 'The second vacation entry is required.',
            's1.required' => 'The first sick entry is required.',
            's2.required' => 'The second sick entry is required.',

        ];
    }
}
