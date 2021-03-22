<?php

namespace Modules\HumanResource\Transformers\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeListResource extends JsonResource
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
            'name' => name_helper($this->name),
            'position' => $this->position->position ?? ''
        ];
    }
}
