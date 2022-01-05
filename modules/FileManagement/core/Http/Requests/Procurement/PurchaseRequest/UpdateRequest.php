<?php

namespace Modules\FileManagement\core\Http\Requests\Procurement\PurchaseRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\HumanResource\core\Models\Employee\Employee;

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
            'requesting'        =>  ['required', Rule::exists($hrtable, 'id')],
            'treasury'          =>  ['required', Rule::exists($hrtable, 'id')],
            'lists'             =>  ['required', 'array'],
            'liaison'           =>  ['sometimes', 'required', Rule::exists($hrtable, 'id')->where('liaison', true)]
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
}
