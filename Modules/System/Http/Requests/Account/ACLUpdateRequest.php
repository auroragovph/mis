<?php

namespace Modules\System\Http\Requests\Account;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ACLUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role'              =>    'nullable|exists:Spatie\Permission\Models\Role,name',
            'permissions'       =>    'nullable|array|exists:Spatie\Permission\Models\Permission,name'
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
