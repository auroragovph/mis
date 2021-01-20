<?php

namespace Modules\FileTracking\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class QRDTResource extends JsonResource
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
            'series' => fts_series($this->id, 'encode')
        ];
    }
}
