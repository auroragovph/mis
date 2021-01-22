<?php

namespace Modules\FileTracking\Entities\Document;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\FileTracking\Entities\FTS_AFL;
use Modules\FileTracking\Entities\FTS_Cafoa;
use Modules\FileTracking\Entities\FTS_DisbursementVoucher;
use Modules\FileTracking\Entities\FTS_Payroll;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;
use Modules\FileTracking\Entities\Travel\FTS_Itinerary;
use Modules\FileTracking\Entities\Travel\FTS_TravelOrder;

class FTS_Document extends Model
{
    protected $guarded = [];
    protected $table = 'fts_documents';

    protected static $logUnguarded = true;
    protected static $logName = 'fts';
    protected static $logOnlyDirty = true;


    public function getSeriesFullAttribute()
    {
        return 'SR-'.str_pad($this->series, 11, '0', STR_PAD_LEFT);
    }

    public function getTypeFullAttribute()
    {
        return doc_type_only($this->type);
    }

    public function getEncodedAttribute()
    {
        // return Carbon::parse($this->created_at)->format('F d, Y h:i A');
        return Carbon::parse($this->created_at)->format('Y-m-d H:i A');
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
        return $this->hasMany(FTS_DA::class, 'document_id');
    }

    public function afl()
    {
        return $this->hasOne(FTS_AFL::class, 'document_id', 'id');
    }

    public function cafoa()
    {
        return $this->hasOne(FTS_Cafoa::class, 'document_id', 'id');
    }

    public function itinerary()
    {
        return $this->hasOne(FTS_Itinerary::class, 'document_id', 'id');
    }

    public function payroll()
    {
        return $this->hasOne(FTS_Payroll::class, 'document_id', 'id');
    }

    public function purchase_request()
    {
        return $this->hasOne(FTS_PurchaseRequest::class, 'document_id', 'id');
    }

    public function travel_order()
    {
        return $this->hasOne(FTS_TravelOrder::class, 'document_id', 'id');
    }

    public function dv()
    {
        return $this->hasOne(FTS_DisbursementVoucher::class, 'document_id', 'id');
    }

    public function tracks()
    {
        return $this->hasMany(FTS_Tracking::class, 'document_id', 'id');
    }

    public function latestTrack()
    {
        return $this->hasOne(FTS_Tracking::class, 'document_id', 'id')->orderBy('created_at', 'desc');
    }

    
}
