<?php

namespace Modules\FileManagement\Http\Requests\Document\Attachment;

use Illuminate\Foundation\Http\FormRequest;

class HardcopyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => ['required'],
            'file'   => ['nullable', 'file'],
            'number' => ['nullable', 'string'],
            'date'   => ['nullable', 'date'],
            'amount' => ['nullable', 'numeric'],
            'page'   => ['nullable', 'numeric'],

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
