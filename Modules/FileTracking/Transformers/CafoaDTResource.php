<?php

namespace Modules\FileTracking\Transformers;

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
            'id' => $this->id,
            'encoded' => $this->document->encoded,
            'qr' => $this->document->seriesFull,
            'number' => $this->number,
            'payee' => $this->payee,
            'amount' => number_format(floatval($this->amount), 2),
            'particulars' => $this->particulars,

            'status' => $this->document->status,

            'print' => route('fts.documents.receipt', ['series' => $this->document->series,]),
            'edit' => route('fts.cafoa.edit', $this->id)
        ];
    }
}
