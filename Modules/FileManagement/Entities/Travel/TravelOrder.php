<?php

namespace Modules\FileManagement\Entities\Travel;

use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Traits\Documents\HasFormable;
use Modules\System\Entities\Office\SYS_Division;
use Modules\System\Entities\Employee;

class TravelOrder extends Model
{
    use HasFormable;
    
    protected $guarded = [];
    protected $table = 'fms_form_travel_order';

    protected $casts = [
        'properties' => 'array'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function charging()
    {
        return $this->belongsTo(SYS_Division::class, 'charging_id');
    }

    public function approval()
    {
        return $this->belongsTo(Employee::class, 'approval_id');
    }

    public function lists()
    {
        return $this->hasMany(TravelOrderList::class, 'form_id');
    }
}
