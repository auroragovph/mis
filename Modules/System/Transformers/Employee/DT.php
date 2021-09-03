<?php

namespace Modules\System\Transformers\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class DT extends JsonResource
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
            $this->id,
            name($this->name),
            office($this->division),

            $this->position->name ?? '',
            $this->employment['type'] ?? '',
            
            '<a href="' . route('sys.admin.employee.edit', $this->id) . '">Edit</a>',
        ];
    }
}
