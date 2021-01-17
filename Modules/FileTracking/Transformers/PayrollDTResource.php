<?php

namespace Modules\FileTracking\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollDTResource extends JsonResource
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
            'id' => $this->id,
            'encoded' => $this->document->encoded,
            'qr' => $this->document->seriesFull,
            'status' => $this->document->status,
            'particulars' => $this->particulars,
            
            'print' => route('fts.documents.receipt', ['series' => $this->document->series,]),
            'edit' => route('fts.payroll.edit', $this->id),

            'name' => $this->name,
            'amount' => number_format(floatval($this->amount), 2)
        ];
    }
}
