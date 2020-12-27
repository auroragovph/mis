<?php

namespace Modules\System\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountDTResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if(array_key_exists('image', $this->employee->info)){
            $image = ($this->employee->info['image'] == null) ? null : asset('storage/employees/profile/'.$this->employee->info['image']);
        }else{
            $image = null;
        }

        return [
            'id' => $this->id,
            'name' => name_helper($this->employee->name),
            'position' => $this->employee->position->position ?? 'N/A',
            'image' => $image,
            'username' => $this->username,
            'status' => $this->status,
            'role' => $this->getRoleNames()->implode(', '),
            'edit' => route('hrm.employee.edit', $this->id)
        ];
    }
}
