<?php

namespace Modules\FileManagement\core\Http\Requests\Document\Attachment;

use Illuminate\Foundation\Http\FormRequest;

class CheckRequest extends FormRequest
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

    public function rules()
    {
        return [
            'document'   => 'required',
            'attachtype' => 'required',
        ];
    }
}
