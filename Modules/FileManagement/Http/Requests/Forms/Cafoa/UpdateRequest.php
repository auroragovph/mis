<?php

namespace Modules\FileManagement\Http\Requests\Forms\Cafoa;

use Illuminate\Validation\Rule;
use Modules\System\Entities\Employee;
use Illuminate\Foundation\Http\FormRequest;

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
            'requesting'        => "required|exists:{$hrtable},id",
            'budget'            => "required|exists:{$hrtable},id",
            'treasury'          => "required|exists:{$hrtable},id",
            'accountant'        => "required|exists:{$hrtable},id",
            'lists'             => "required|array",
            'liaison'           => [
                                    'sometimes',
                                    'required',
                                    Rule::exists($hrtable, 'id')->where('liaison', 1)
                                    ]
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
