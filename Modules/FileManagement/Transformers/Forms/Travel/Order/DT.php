<?php

namespace Modules\FileManagement\Transformers\Forms\Travel\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class DT extends JsonResource
{
    public function toArray($request)
    {

        
        return [
            $this->id,
            "<a href='".route('fms.travel.order.show', $this->id)."'>{$this->document->qrcode}</a>",
            $this->number,
            $this->destination,
            $this->purpose,
            $this->departure,
            show_status($this->document->status)
        ];
    }
}
