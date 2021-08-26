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
        return [
            'id' => $this->id,
            'qr' => $this->document->qr,
            'number' => $this->number,
            
            'office' => office_helper($this->document->division),
            'particulars' => $this->particulars,
            'status' => show_status($this->document->status),
            'amount' => number_format($this->total_amount, 2),

            'action' => '
                <a href="'.route('fms.procurement.request.show', $this->id).'">View</a>
                <a href="'.route('fms.procurement.request.edit', $this->id).'">Edit</a>
            '
        ];
    }
}
