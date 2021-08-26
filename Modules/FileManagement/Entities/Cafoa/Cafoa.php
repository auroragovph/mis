<?php

namespace Modules\FileManagement\Entities\Cafoa;

use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Traits\Documents\HasDocument;
use Modules\FileManagement\Traits\Documents\HasFormable;

class Cafoa extends Model
{
    use HasFormable, HasDocument;

    protected $guarded = [];
    protected $table = 'fms_form_cafoa';
    protected $casts = [
        'signatories'   => 'json',
        'lists'         => 'json',
        'ledger'        => 'collection'
    ];

    public function getTotalAmountAttribute()
    {
        $lists = collect($this->lists);

        return floatval($lists->sum(function($row){
            return floatval($row['amount'] ?? 0);
        }));
    }
    
}
