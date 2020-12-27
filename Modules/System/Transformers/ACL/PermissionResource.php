<?php

namespace Modules\System\Transformers\ACL;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
                'id' => $this->name,
                'text' => $this->name
            ];
        }

        return [
            'name' => $this->name,
            'id' => $this->id
        ];
    }
}
