<?php

namespace Modules\FileManagement\Transformers\Forms\Travel;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelOrderDTResource extends JsonResource
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
            // 'encoded' => $this->document->encoded,
            'qr' => $this->document->qrcode,
            'number' => $this->number,
            'destination' => $this->destination,
            'purpose' => $this->purpose,
            'departure' => $this->departure,
            'status' => show_status($this->document->status),
            'action' => '
                <a href="'.route('fms.travel.order.show', $this->id).'">View</a>
                <a href="'.route('fms.travel.order.edit', $this->id).'">Edit</a>
            '
        ];
    }
}
