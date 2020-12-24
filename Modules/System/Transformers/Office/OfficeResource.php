<?php

namespace Modules\System\Transformers\Office;

use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
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
                'text' => $this->name
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'alias' => $this->alias,
            'division_count' => ($this->divisions->count() - 1) ?? null,
            'employee_count' => 0
        ];
    }

}
