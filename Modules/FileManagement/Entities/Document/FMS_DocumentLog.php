<?php

namespace Modules\FileManagement\Entities\Document;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FMS_DocumentLog extends Model
{
    protected $guarded = [];
    protected $table = 'fms_documents_log';

    public static function log($id, $action)
    {
        return static::create([
            'document_id' => $id,
            'user_id' => Auth::user()->id,
            'action' => $action
        ]);
    }
}
