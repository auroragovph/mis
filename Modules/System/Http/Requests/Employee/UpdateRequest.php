<?php

namespace Modules\System\Http\Requests\Employee;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\System\Entities\Office\Division;
use Modules\HumanResource\Entities\Employee\Position;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $division_table = (new Division())->getTable();
        $position_table = (new Position())->getTable();

        return [
            'fname'       => ['required'],
            'mname'       => ['nullable'],
            'lname'       => ['required'],
            'address'     => ['required'],
            'contact'     => ['required'],
            'bday'        => ['required'],
            'civil'       => ['required'],
            'sex'         => ['required'],

            'division'    => ['required', 'integer', Rule::exists($division_table, 'id')],
            'position'    => ['required', 'integer', Rule::exists($position_table, 'id')],
            'appointment' => ['required'],
            'card'        => ['nullable'],

            // 'dsgdfh5'        => ['required'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (authenticated()->can('sys.employee.update')) ? true : false;
    }
}
