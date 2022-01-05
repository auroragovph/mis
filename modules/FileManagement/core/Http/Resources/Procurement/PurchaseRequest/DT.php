<?php

namespace Modules\FileManagement\core\Http\Resources\Procurement\PurchaseRequest;

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
        $status = \Modules\FileManagement\core\Enums\Document\Status::from($this->series->status);

        $action = '<a href="' . route('fms.procurement.request.show', $this->id) . '">View</a>';

        if($status->value !== 'CANCELLED'){
            $action .= ' | <a href="' . route('fms.procurement.request.edit', $this->id) . '">Edit</a>';
        }



        return [
            'id'          => $this->id,
            'qr'          => $this->series->qrcode,
            'number'      => $this->number,

            'office'      => office($this->series->office),
            'particulars' => $this->particulars,
            'amount'      => number_format($this->total_amount, 2),

            'action'      => $action
        ];
    }
}
