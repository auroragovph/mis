<?php

namespace Modules\FileManagement\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;

class FMS_PurchaseRequest extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    protected $guarded = [];
    protected $table = 'fms_form_purchase_request';
    protected $casts = [
        'signatories' => 'json',
        'lists' => 'collection'
    ];

    public function requesting()
    {
        return $this->belongsTo(HR_Employee::class, 'signatories->requesting', 'id');
    }

    public function treasury()
    {
        return $this->belongsTo(HR_Employee::class, 'signatories->treasury', 'id');
    }

    public function approval()
    {
        return $this->belongsTo(HR_Employee::class, 'signatories->approval', 'id');
    }


}
