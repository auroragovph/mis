<?php

namespace Modules\FileManagement\Entities\Procurement;

use Modules\System\Entities\Employee;
use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Traits\Documents\HasDocument;
use Modules\FileManagement\Traits\Documents\HasFormable;

class PurchaseRequest extends Model
{
    use HasDocument, HasFormable;

    protected $guarded = [];
    protected $table = 'fms_form_purchase_request';
    protected $casts = [
        'lists' => 'json',
        'properties' => 'json'
    ];

    public function requesting()
    {
        return $this->belongsTo(Employee::class, 'requesting_id');
    }

    public function treasury()
    {
        return $this->belongsTo(Employee::class, 'treasury_id');
    }

    public function approval()
    {
        return $this->belongsTo(Employee::class, 'approving_id');
    }
    
    
}
