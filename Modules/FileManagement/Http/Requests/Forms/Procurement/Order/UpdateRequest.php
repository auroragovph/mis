<?php

namespace Modules\FileManagement\Http\Requests\Forms\Procurement\Order;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\AwardCommittee\Entities\Procurement\Supplier;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $supplier_table = (new Supplier())->getTable();
        $hr_table       = (new Employee())->getTable();

        return [
            'supplier'            => ['required', 'integer', Rule::exists($supplier_table, 'id')],
            'number'              => ['required', 'string'],
            'mode_of_procurement' => ['required', 'string'],
            'pr_number'           => ['nullable'],
            'delivery_place'      => ['required', 'string'],
            'delivery_date'       => ['required', 'date'],
            'delivery_term'       => ['required', 'string'],
            'delivery_payment'    => ['required', 'string'],
            'lists'               => ['required', 'array'],
            'approver'           => ['required', 'integer', Rule::exists($hr_table, 'id')],
            'particulars'         => ['required', 'string'],

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->route('id') != session()->get('fms.document.edit.po')){
            return false;
        }

        return (authenticated()->can('fms.document.edit')) ? true : false;

    }
}
