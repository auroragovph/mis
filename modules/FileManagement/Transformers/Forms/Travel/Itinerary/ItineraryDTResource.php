<?php

namespace Modules\FileManagement\Transformers\Forms\Travel\Itinerary;

use Illuminate\Http\Resources\Json\JsonResource;

class ItineraryDTResource extends JsonResource
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
            'encoded' => $this->document->encoded,
            'qr' => $this->document->qr,
            'employee' => name_helper($this->employee->name),
            'number' => $this->number,
            'date' => $this->travel_date,
            'purpose' => $this->travel_purpose,
            'amount' => number_format(collect($this->lists)->sum('amount'), 2),
            'show' => route('fms.travel.itinerary.show', $this->id),
            'edit' => route('fms.travel.itinerary.edit', $this->id)
        ];
    }
}
