<?php

namespace Modules\FileTracking\Http\Requests\Payroll;

use Illuminate\Validation\Rule;
use Modules\FileTracking\Entities\FTS_QR;
use Illuminate\Foundation\Http\FormRequest;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;

class PayrollStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'series'        =>  ['sometimes', 'required', Rule::exists((new FTS_QR())->getTable(), 'id')->where('status', 0)],
            'division'      =>  ['required', Rule::exists((new SYS_Division())->getTable(), 'id')],
            'liaison'       =>  ['required', Rule::exists((new HR_Employee())->getTable(), 'id')->where('liaison', 1)],
            'particulars'   => 'required',

            'name'          => 'required',
            'amount'        => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // checking permissions
        if(!authenticated()->can('fts.document.create')){

            // saving the activity logs
            activitylog([
                'name' => 'fts',
                'log' => 'Tried to store Payroll document but failed. Reason: You dont have the permissions to execute this command.'
            ]);

            return false;
        }

        return true;
    }
}
