<?php

namespace Modules\System\Transformers\Office;

use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
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
                'text' => office_helper($this)
            ];
        }
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'alias' => $this->alias,
            'office' => $this->office->name,
            'employee_counts' => 0
        ];
    }
}
