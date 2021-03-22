<?php

namespace Modules\FileManagement\Http\Requests\Forms\Procurement\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        if(session()->get('fms.document.create.po') == null){
            return false;
        }

        return (authenticated()->can('fms.document.create')) ? true : false;

    }
}
