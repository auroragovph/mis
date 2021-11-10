<?php

namespace Modules\FileManagement\Http\Requests\Forms\AFL;

use Illuminate\Validation\Rule;
use Modules\System\Entities\Employee;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'employee'      =>  ['sometimes', 'required', Rule::exists($hrtable, 'id')],
            'leave_type'    => 'sometimes|required',
            'inclusive'     => 'required',
            'caf'           => 'required',
            'v1'            => 'required',
            's1'            => 'required',
            'v2'            => 'required',
            's2'            => 'required',
            'approval'      => ['required', 'integer', Rule::exists($hrtable, 'id')],
            'hr'            => ['required', 'integer', Rule::exists($hrtable, 'id')],
            'liaison'       => ['sometimes', 'required', 'integer', Rule::exists($hrtable, 'id')->where('liaison', 1)]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (authenticated()->can('fms.document.create')) ? true : false;
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