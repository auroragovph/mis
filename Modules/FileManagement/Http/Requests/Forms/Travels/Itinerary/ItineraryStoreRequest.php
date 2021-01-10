<?php

namespace Modules\FileManagement\Http\Requests\Forms\Travels\Itinerary;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;

class ItineraryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $hrtable = HR_Employee::getTableName();

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
