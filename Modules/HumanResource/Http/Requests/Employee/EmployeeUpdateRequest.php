<?php

namespace Modules\HumanResource\Http\Requests\Employee;

use App\Models\Account;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\HumanResource\Entities\HR_Employee;

class EmployeeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch($this->header('x-edit-employee')){
            case 'information': 
                return [
                    'profile_avatar'    =>     'sometimes|image',
                    'firstname'         =>     'required|string',
                    'middlename'        =>     'nullable|string',
                    'lastname'          =>     'required|string',
                    'phone'             =>     'nullable|numeric',
                    'address'           =>     'required',
                    'civil'             =>     'required',
                    'birthday'          =>     'required|date',
                    'sex'               =>     'required'
                ];
                break;

                case 'employment': 
                    return [
                        'division'      =>      'required|exists:sys_division,id',
                        'position'      =>      'required|exists:hrm_plantilla,id',
                        'appointment'   =>      'required',
                        'card'          =>      [   'required', 
                                                    Rule::unique(HR_Employee::class, 'card')->ignore($this->route('id'))
                                                ]
                    ];
                    break;

                case 'credentials': 
                    return [
                        'password'      =>      'bail|sometimes|confirmed',
                        'password_old'  =>      [
                                                    'required',
                                                    function($attribute, $value, $fail){
                                                        if(password_verify($value, $this->employee->account->password) == false){
                                                            $fail('Incorrect old password.');
                                                        }
                                                    }
                                                ],
                        'username'      =>      [
                                                    'required',
                                                    Rule::unique(Account::class, 'username')->ignore($this->employee->id, 'employee_id')
                                                ]

                    ];
                    break;

            default: 
                return [];
                break;

        }

        return [];

        
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ($this->header('x-edit-employee') == null) ? false : true;
    }
}
