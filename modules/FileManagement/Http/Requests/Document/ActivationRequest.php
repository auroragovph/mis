<?php

namespace Modules\FileManagement\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class ActivationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'document'      =>  ['required'],
            'liaison'       =>  ['required']
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (authenticated()->can('fms.sa.activate')) ? true : false;
    }
}
