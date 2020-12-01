<?php

namespace Modules\FileTracking\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Spatie\Activitylog\Traits\LogsActivity;

class FTS_PurchaseRequest extends Model
{
    use LogsActivity;
    
    protected $guarded = [];
    protected $table = 'fts_form_purchase_request';

    protected static $logUnguarded = true;
    protected static $logName = 'fts';
    protected static $logOnlyDirty = true;

    public function document()
    {
        return $this->belongsTo(FTS_Document::class, 'document_id', 'id');
    }
}
