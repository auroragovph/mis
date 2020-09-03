<?php

namespace Modules\FileManagement\Entities\Document;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\Entities\Procurement\FMS_PurchaseRequest;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileManagement\Entities\Document\FMS_DocumentAttach;
use Modules\FileManagement\Entities\Obr\FMS_ObligationRequest;
use Modules\FileManagement\Entities\Travel\FMS_TravelOrder;

class FMS_Document extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'fms_documents';

    public static function directStore($liaison, $type)
    {
        return static::create([
            'division_id' => Auth::user()->employee->division_id,
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => $type
        ]);
    }

    public function encoder()
    {
        return $this->belongsTo(HR_Employee::class, 'encoder_id', 'id');
    }

    public function liaison()
    {
        return $this->belongsTo(HR_Employee::class, 'liaison_id', 'id');
    }

    public function division()
    {
        return $this->belongsTo(SYS_Division::class, 'division_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(FMS_DocumentAttach::class, 'document_id', 'id');
    }


    public function purchase_request()
    {
        return $this->hasOne(FMS_PurchaseRequest::class, 'document_id', 'id');
    }

    public function obligation_request()
    {
        return $this->hasOne(FMS_ObligationRequest::class, 'document_id', 'id');
    }

    public function travel_order()
    {
        return $this->hasOne(FMS_TravelOrder::class, 'document_id', 'id');
    }
}
