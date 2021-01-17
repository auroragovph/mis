<?php

namespace Modules\FileTracking\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\FileTracking\Entities\Document\FTS_Document;

class FTS_DisbursementVoucher extends Model
{
    protected $guarded = [];
    protected $table = 'fts_form_dv';


    public function document()
    {
        return $this->belongsTo(FTS_Document::class, 'document_id');
    }
}
