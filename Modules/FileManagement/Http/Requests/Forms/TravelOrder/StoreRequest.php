<?php

namespace Modules\FileManagement\Http\Requests\Forms\TravelOrder;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\System\Entities\Employee;
use Modules\System\Entities\Office\SYS_Division;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employees'     => 'required',
            'departure'     => 'required|date',
            'arrival'       => 'required|date',
            'charging'      =>  [
                                    'required',
                                    Rule::exists(SYS_Division::getTableName(), 'id')
                                ],
            'purpose'       => 'required',
            'liaison'       => [
                                    'required',
                                    Rule::exists(Employee::getTableName(), 'id')->where('liaison', 1)
                                ],
            'approval'       => [
                                    'required',
                                    Rule::exists(Employee::getTableName(), 'id')
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
        return (authenticated()->can('fms.document.create')) ? true : false;

    }
}
