<?php

namespace Modules\FileManagement\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Employee;

class ActivationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $employees_table = (new Employee())->getTable();

        return [
            'document'      =>  ['required'],
            'liaison'       =>  ['required']
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (authenticated()->can('fms.sa.activate')) ? true : false;
    }
}
