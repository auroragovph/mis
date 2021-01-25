<?php

namespace Modules\FileTracking\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TODTResource extends JsonResource
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
            'encoded' => $this->document->encoded,
            'qr' => $this->document->seriesFull,
            'status' => $this->document->status,
            'particulars' => $this->particulars,
            
            'print' => route('fts.documents.receipt', ['series' => $this->document->series,]),
            'edit' => route('fts.travel.order.edit', $this->id),

            'number'        => $this->number,
            'date'          => $this->date,
            'employees'     => collect($this->employees)->map(function($item, $key){
                                    return $item['employee']." - ".$item['position'];
                                })->implode(', '),
            'destination'   => $this->destination,
            'departure'     => $this->departure,
            'arrival'       => $this->arrival
        ];
    }
}
