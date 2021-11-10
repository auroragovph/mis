<?php

namespace Modules\System\Http\Requests\Division;

use Illuminate\Validation\Rule;
use Modules\System\Entities\Office\Office;
use Illuminate\Foundation\Http\FormRequest;
use Modules\HumanResource\Entities\Employee\Employee;

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
        $office_table = (new Office())->getTable();

        return [
            'name'              =>  ['required'],
            'alias'             =>  ['string'],
            'office'            =>  ['required', Rule::exists($office_table, 'id')],
            'division_head'     =>  ['required', Rule::exists($employee_table, 'id')]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (authenticated()->can('sys.office.create')) ? true : false;
    }
}
