<?php

namespace Modules\System\Transformers\ACL;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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

        if($request->header('X-KTDT')){


            return [
                'id' => $this->id,
                'name' => $this->name,
                'permissions' => $this->permissions()->get()->pluck('name')
            ];
        }

        return [
            'name' => $this->name
        ];
    }
}
