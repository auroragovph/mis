<?php

namespace Modules\FileManagement\Http\Requests\Forms\TravelOrder;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\System\Entities\Office\Division;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $employee_table = (new Employee())->getTable();
        $division_table = (new Division())->getTable();

        return [
            'employees' => ['required', 'array'],
            'departure' => ['required', 'date'],
            'arrival'   => ['required', 'date'],
            'charging'  => ['required', Rule::exists($division_table, 'id')],

            'purpose'   => ['required'],
            'liaison'   => ['sometimes', 'required', Rule::exists($employee_table, 'id')->where('liaison', 1)],
            'requester' => ['required', Rule::exists($employee_table, 'id')],
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
}
