<?php

namespace Modules\HumanResource\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'profile_avatar' => 'sometimes|image',
            'firstname' => 'required|string',
            'middlename' => 'sometimes|string',
            'lastname' => 'required|string',
            'phone' => 'required|numeric',
            'address' => 'required',
            'civil' => 'required',
            'birthday' => 'required|date',
            'sex' => 'required',

            'division' => 'required|exists:sys_division,id',
            'position' => 'required|exists:hrm_plantilla,id',
            'appointment' => 'required',
            'card' => 'required|unique:hrm_employees,card',

            'account' => 'required',

            // special occations
            'username' => 'required_if:account,manual',
            'password' => 'required_if:account,manual|confirmed'

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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'profile_avatar.image' => 'Invalid image type. Please upload JPG or PNG file.',

            'firstname.required' => 'First name is required.',
            'firstname.string' => 'First name contains invalid character.',

            'middlename.string' => 'Middle name contains invalid character.',

            'phone.required' => 'Phone number is required.',
            'phone.numeric' => 'Phone number contains invalid character.',

            'address.required' => 'Address is required.',

            'civil.required' => 'Civil status is required.',

            'birthday.required' => 'Birth date is required.',
            'birthday.date' => 'Invalid birth date format.',

            'sex.required' => 'Select sex in the list.',

            'division.required' => 'Division is required.',
            'division.exists' => 'Division not found.',

            'position.required' => 'Position is required.',
            'position.exists' => 'Position not found.',

            'appointment.required' => 'Select appointment in the list.',

            'card.required' => 'ID Card is required.',
            'card.unique' => 'ID Card already exists.',

            'account.required' => 'Choose account creation.',
        ];
    }
}
