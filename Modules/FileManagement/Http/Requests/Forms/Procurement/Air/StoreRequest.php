<?php

namespace Modules\FileManagement\Http\Requests\Forms\Procurement\Air;

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
            'document_id'       => ['required'],
            'po_id'             => ['required'],
            'number'            => ['required'],
            'invoice_number'    => ['required'],
            'invoice_date'      => ['required'],
            'lists'             => ['required', 'array']
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
