<?php

namespace Modules\FileManagement\Transformers\Forms\Procurement;

use Illuminate\Http\Resources\Json\JsonResource;

class ProcurementDTResource extends JsonResource
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
            'number' => $this->number,
            'qr' => $this->document->qr,
            'encoded' => $this->document->encoded,
            'office' => office_helper($this->document->division),
        ]
    }
}
