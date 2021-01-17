<?php

namespace Modules\FileTracking\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\FileTracking\Entities\Document\FTS_Document;

class FTS_PurchaseRequest extends Model
{
    
    protected $guarded = [];
    protected $table = 'fts_form_pr';


    public function document()
    {
        return $this->belongsTo(FTS_Document::class, 'document_id', 'id');
    }
}
