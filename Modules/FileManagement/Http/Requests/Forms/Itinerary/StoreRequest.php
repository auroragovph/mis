<?php

namespace Modules\FileManagement\Http\Requests\Forms\Itinerary;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\HumanResource\Entities\HR_Employee;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $hrtable = (new HR_Employee())->getTable();
        
        return [
            'number'        => 'sometimes|nullable',
            'employee'      => 'required',
            'purpose'       => 'required',
            'lists'         => 'required|array',
            'supervisor'    =>  ['required',Rule::exists($hrtable, 'id')],
            'approving'     =>  ['required',Rule::exists($hrtable, 'id')],
            'liaison'       =>  ['required',Rule::exists($hrtable, 'id')->where('liaison', 1)]
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
