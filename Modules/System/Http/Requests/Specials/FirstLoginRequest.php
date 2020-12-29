<?php

namespace Modules\System\Http\Requests\Specials;

use App\Models\Account;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FirstLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'profile_avatar'        => 'sometimes|image',
            'firstname'             => 'required|string',
            'middlename'            => 'nullable|string',
            'lastname'              => 'required|string',
            'phone'                 => 'required|numeric',
            'address'               => 'required',
            'civil'                 => 'required',
            'birthday'              => 'required|date',
            'sex'                   => 'required',

            'division'              => 'required|exists:sys_division,id',
            'position'              => 'required|exists:hrm_plantilla,id',
            'appointment'           => 'required',
            'card'                  => 'required|unique:hrm_employees,card',

            'username'              => ['required', Rule::unique(Account::class, 'username')->ignore($this->employee->account->id)],
            'password'              => 'required|confirmed'

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->employee->id !== $this->employee->id){
            return false;
        }

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
