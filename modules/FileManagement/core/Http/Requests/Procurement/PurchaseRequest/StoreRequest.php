<?php

namespace Modules\FileManagement\core\Http\Requests\Procurement\PurchaseRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\HumanResource\core\Models\Employee\Employee;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        $hrtable = (new Employee())->getTable();

        return [
            'requesting'        =>  ['required', Rule::exists($hrtable, 'id')],
            'treasury'          =>  ['required', Rule::exists($hrtable, 'id')],
            'lists'             =>  ['required', 'array'],
            'liaison'           =>  ['sometimes', 'required', Rule::exists($hrtable, 'id')->where('liaison', 1)]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return (authenticated()->can('fms.document.create')) ? true : false;
        return true;
    }
}
