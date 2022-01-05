<?php

namespace Modules\FileManagement\core\Traits;
use Modules\FileManagement\core\Models\Document\Series;

trait HasSeries{

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }
}
