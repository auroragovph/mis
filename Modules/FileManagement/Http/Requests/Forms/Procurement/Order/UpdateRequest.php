<?php

namespace Modules\FileManagement\Http\Requests\Forms\Procurement\Order;

use Illuminate\Foundation\Http\FormRequest;

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
            //
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->route('id') != session()->get('fms.document.edit.po')){
            return false;
        }

        return (authenticated()->can('fms.document.edit')) ? true : false;

    }
}
