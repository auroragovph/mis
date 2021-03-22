<?php

namespace Modules\FileManagement\Transformers\Forms\Procurement\Request;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestDTResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $lists = collect($this->lists);

        return [
            'id' => $this->id,
            'number' => $this->number,
            'qr' => $this->document->qr,
            'encoded' => $this->document->encoded,
            'office' => office_helper($this->document->division),
            'amount' => number_format($lists->sum(function($row){
                
                $qty = intval($row['quantity'] ?? 0);
                $amount = floatval($row['amount'] ?? 0);
                return $qty  * $amount;
            }), 2),
            'edit' => route('fms.procurement.request.edit', $this->id),
            'show' => route('fms.procurement.request.show', $this->id)
        ];
    }
}
