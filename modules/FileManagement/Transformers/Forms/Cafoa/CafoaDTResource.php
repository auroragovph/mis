<?php

namespace Modules\FileManagement\Transformers\Forms\Cafoa;

use Illuminate\Http\Resources\Json\JsonResource;

class CafoaDTResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'qr'          => $this->document->qr,
            'number'      => $this->number,
            'payee'       => $this->payee,
            'office'      => office_helper($this->document->division),
            'particulars' => $this->particulars,
            'amount'      => number_format($this->total_amount, 2),
            'status'      => show_status($this->document->status),

            'action'      => '
                <a href="' . route('fms.cafoa.show', $this->id) . '">View</a>
                <a href="' . route('fms.cafoa.edit', $this->id) . '">Edit</a>
            ',
        ];
    }
}
