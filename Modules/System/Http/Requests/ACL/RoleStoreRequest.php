<?php

namespace Modules\System\Http\Requests\ACL;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class RoleStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $roleTable = (new Role())->getTable();

        return [
            'name'  => "required|unique:{$roleTable},name",
            'permissions'   => "required|array"
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (authenticated()->can('sys.sudo')) ? true : false;
    }
}
