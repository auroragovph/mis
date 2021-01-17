<?php

namespace Modules\FileTracking\Http\Requests\Itinerary;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'division'      =>  ['required', Rule::exists((new SYS_Division())->getTable(), 'id')],
            'liaison'       =>  ['required', Rule::exists((new HR_Employee())->getTable(), 'id')->where('liaison', 1)],
            'particulars'   => 'required',

            'name'          => 'required',
            'position'      => 'required',
            'amount'        => 'required',
            'destination'   => 'required',
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
        if(!authenticated()->can('fts.document.edit')){

            // saving the activity logs
            activitylog([
                'name' => 'fts',
                'log' => 'Tried to update itinerary of travel document but failed. Reason: You dont have the permissions to execute this command.'
            ]);

            return false;
        }

        return true;
    }
}
