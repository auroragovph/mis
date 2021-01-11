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
            'id' => $this->id,
            'encoded' => $this->document->encoded,
            'qr' => $this->document->qr,
            'number' => $this->number,
            'payee' => $this->payee,
            'amount' => number_format(floatval(collect($this->lists)->sum(function($row){
                return floatval($row['amount'] ?? 0);
            })), 2),

            'status' => $this->document->status,
            'show' => route('fms.cafoa.show', $this->id),
            'edit' => route('fms.cafoa.edit', $this->id)
        ];
    }
}