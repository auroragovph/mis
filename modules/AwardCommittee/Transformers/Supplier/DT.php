<?php

namespace Modules\AwardCommittee\Transformers\Supplier;

use Illuminate\Http\Resources\Json\JsonResource;

class DT extends JsonResource
{
    public function toArray($request)
    {
        return [
            $this->id,
            $this->name,
            $this->owner,
            $this->address,
            $this->tin,
            '<a href="'.route('bac.supplier.edit', $this->id).'">Edit</a>',
        ];
    }
}
