<?php

namespace Modules\FileManagement\Transformers\Forms\Procurement\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDTResource extends JsonResource
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
            'particulars' => $this->particulars,
            'amount' => number_format($lists->sum(function($row){
                
                $qty = intval($row['quantity'] ?? 0);
                $amount = floatval($row['amount'] ?? 0);
                return $qty  * $amount;
            }), 2),
            'edit' => route('fms.procurement.order.edit', $this->id),
            'show' => route('fms.procurement.order.show', $this->id)
        ];
    }
}
