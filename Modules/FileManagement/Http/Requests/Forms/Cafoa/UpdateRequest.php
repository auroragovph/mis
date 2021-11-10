<?php

namespace Modules\FileManagement\Http\Requests\Forms\Cafoa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\HumanResource\Entities\Employee\Employee;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $hrtable = (new Employee())->getTable();

        return [
            'number'      => ['nullable', 'string'],
            'requester'   => ['required', Rule::exists($hrtable, 'id')],
            'budget'      => ['required', Rule::exists($hrtable, 'id')],
            'treasury'    => ['required', Rule::exists($hrtable, 'id')],
            'accountant'  => ['required', Rule::exists($hrtable, 'id')],
            'lists'       => ['required', 'array'],
            'particulars' => ['required'],
            'liaison'     => [
                'sometimes',
                'required',
                Rule::exists($hrtable, 'id')->where('liaison', 1),
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (authenticated()->can('fms.document.edit')) ? true : false;
    }
}
