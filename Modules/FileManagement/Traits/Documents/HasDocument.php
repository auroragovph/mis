<?php
namespace Modules\FileManagement\Traits\Documents;

use Modules\FileManagement\Entities\Document\Document;

trait HasDocument{

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
}