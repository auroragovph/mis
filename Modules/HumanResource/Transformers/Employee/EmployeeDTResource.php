<?php

namespace Modules\HumanResource\Transformers\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDTResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if(array_key_exists('image', $this->info)){
            $image = ($this->info['image'] == null) ? null : asset('storage/employees/profile/'.$this->info['image']);
        }else{
            $image = null;
        }


        $employment = $this->employment;



        return [
            'id' => $this->id,
            'name' => name_helper($this->name),
            'position' => $this->position->position ?? 'N/A',
            'office' => office_helper($this->division),
            'appointment' => $employment['type'] ?? null,
            'image' => $image,
            'edit' => route('hrm.employee.edit', $this->id)
        ];
    }
}
