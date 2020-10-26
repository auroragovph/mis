<?php

namespace Modules\FileTracking\Entities\Document;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;

class FTS_Document extends Model
{
    protected $guarded = [];
    protected $table = 'fts_documents';

    public function getSeriesFullAttribute()
    {
        return 'SR-'.str_pad($this->series, 11, '0', STR_PAD_LEFT);
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

    public function purchase_request()
    {
        return $this->hasOne(FTS_PurchaseRequest::class, 'document_id', 'id');
    }

    public function tracks()
    {
        return $this->hasMany(FTS_Tracking::class, 'document_id', 'id');
    }

    
}
