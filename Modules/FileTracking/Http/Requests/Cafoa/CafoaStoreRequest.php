<?php

namespace Modules\FileTracking\Http\Requests\Cafoa;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\FileTracking\Entities\FTS_QR;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;

class CafoaStoreRequest extends FormRequest
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

            'payee'         => 'required',
            'amount'        => 'required',
            'particulars'   => 'required'
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
