<?php

namespace Modules\HumanResource\Transformers\Plantilla;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        if($request->header('X-Select2')){
            return [
                'id' => $this->id,
                'text' => $this->position
            ];
        }

        return [
            'id' => $this->id,
            'position' => $this->position,
        ];
    }
}
