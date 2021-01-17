<?php

namespace Modules\FileTracking\Entities\Travel;

use Illuminate\Database\Eloquent\Model;
use Modules\FileTracking\Entities\Document\FTS_Document;

class FTS_Itinerary extends Model
{
    protected $guarded = [];
    protected $table = 'fts_form_iot';

    public function document()
    {
        return $this->belongsTo(FTS_Document::class, 'document_id');
    }
}
