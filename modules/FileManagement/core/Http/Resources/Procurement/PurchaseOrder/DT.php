<?php

namespace Modules\FileManagement\core\Http\Resources\Procurement\PurchaseOrder;

use Illuminate\Http\Resources\Json\JsonResource;

class DT extends JsonResource
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
            'number'      => $this->number,
            'qr'          => $this->series->qr,
            'office'      => office($this->series->office),

            'supplier'    => $this->supplier['name'] ?? null,

            'particulars' => $this->particulars,
            'amount'      => number_format($this->total_amount, 2),
            'action'      => '
                <a href="' . route('fms.procurement.order.show', $this->id) . '">View</a> |
                <a href="' . route('fms.procurement.order.edit', $this->id) . '">Edit</a>
            ',
        ];
    }
}
