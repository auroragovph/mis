<?php

namespace Modules\HumanResource\Transformers\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeSelectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
