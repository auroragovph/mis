<?php

namespace Modules\FileManagement\core\Http\Requests\Document\Attachment;

use Illuminate\Foundation\Http\FormRequest;

class HardcopyRequest extends FormRequest
{
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
}
