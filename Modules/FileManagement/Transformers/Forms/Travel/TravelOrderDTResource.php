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

        if(empty($this->lists)){

            $employees = [];

        }else{
            $employees = '';

            foreach($this->lists as $list){
                $employees .= name_helper($list->employee->name).", ";
            }
        }


        return [
            'id' => $this->id,
            'encoded' => $this->document->encoded,
            'qr' => $this->document->qr,
            'number' => $this->number,
            'employees' => $employees,
            'destination' => $this->destination,
            'departure' => $this->departure,
            'status' => $this->document->status,
            'show' => route('fms.travel.order.show', $this->id),
            'edit' => route('fms.travel.order.edit', $this->id)
        ];
    }
}
