<?php

namespace Modules\FileManagement\Transformers\Forms\AFL;

use Illuminate\Http\Resources\Json\JsonResource;

class AFLDTResource extends JsonResource
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
            'qr' => $this->document->qr,

            'name' => name_helper($this->employee->name),
            'type' => ($this->properties['type'] == 'Others') ? $this->properties['details'] : $this->properties['type'],
            

            'status' => $this->document->status,
            'show' => route('fms.afl.show', $this->id),
            'edit' => route('fms.afl.edit', $this->id)
        ];
    }
}
