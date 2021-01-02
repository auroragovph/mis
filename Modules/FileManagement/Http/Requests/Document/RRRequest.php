<?php

namespace Modules\FileManagement\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class RRRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if($this->header('x-rr-submit')){

            return [
                'purpose' => 'required',
                'status' => 'required'
            ];

        }

        return [
            'document' => 'required',
            'liaison' => 'required'
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
