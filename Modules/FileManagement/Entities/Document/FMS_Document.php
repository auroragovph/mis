<?php

namespace Modules\FileManagement\Entities\Document;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\AFL\FMS_AFL;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileManagement\Entities\Cafoa\FMS_Cafoa;
use Modules\FileManagement\Entities\Travel\FMS_TravelOrder;
// use Modules\FileManagement\Entities\Obr\FMS_ObligationRequest;
use Modules\FileManagement\Entities\Document\FMS_DocumentAttach;
use Modules\FileManagement\Entities\Procurement\FMS_PurchaseRequest;
use Modules\FileManagement\Entities\Travel\FMS_Itinerary;

use Modules\FileManagement\Traits\Documents\Relationships;


class FMS_Document extends Model
{
    use SoftDeletes, Relationships;

    protected $guarded = [];
    protected $table = 'fms_documents';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function directStore($liaison, $type)
    {
        return static::create([
            'division_id' => Auth::user()->employee->division_id,
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => $type
        ]);
    }

    public function scopeOnlyDivision($query)
    {
        return $query->where('division_id', auth()->user()->employee->division_id);
    }

    public function getQrAttribute()
    {
        return Carbon::parse($this->created_at)->format('Ymd').$this->id;
    }

    public function getEncodedAttribute()
    {
        return Carbon::parse($this->created_at)->format('F d, Y h:i A');
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
}
