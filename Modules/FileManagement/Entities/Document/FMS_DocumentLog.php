<?php

namespace Modules\FileManagement\Entities\Document;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class FMS_DocumentLog extends Model
{
    protected $guarded = [];
    protected $table = 'fms_documents_log';
    protected $casts = ['properties' => 'collection'];



    public static function log($document_id, $description = null, $properties = null)
    {
        return static::create([
            'document_id' => $document_id,
            'user_id' => Auth::id(),
            'description' => $description,
            'properties' => $properties
        ]);
    }
}
