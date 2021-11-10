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
            'office' => office_helper($this->document->division),
            'particulars' => $this->particulars,
            'amount' => number_format($this->total_amount, 2),
            'action' => '
                <a href="'.route('fms.procurement.order.show', $this->id).'">View</a>
                <a href="'.route('fms.procurement.order.edit', $this->id).'">Edit</a>
            '
        ];
    }
}
