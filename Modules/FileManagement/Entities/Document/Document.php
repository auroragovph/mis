<?php

namespace Modules\FileManagement\Entities\Document;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\Entities\Document\Form;
use Modules\FileManagement\Traits\Documents\Relationships;
use Modules\System\Entities\Employee;
use Modules\System\Entities\Office\SYS_Division;

class Document extends Model
{
    use SoftDeletes, Relationships;

    protected $guarded = [];
    protected $table = 'fms_documents';
    protected $casts = [
        'properties' => 'json',
        'status' => 'integer',
    ];

    public static function getTableName()
    {
        return with(new static )->getTable();
    }

    /**
     * @param int $liaison
     * @param int $type
     * @param string $particulars
     * @return $this
     */
    public static function directStore($liaison, $type, $particulars = null)
    {
        return static::create([
            'division_id' => Auth::user()->employee->division_id,
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->employee_id,
            'type' => $type,
            // 'particulars' => $particulars
        ]);
    }

    public function scopeOnlyDivision($query)
    {
        return $query->where('division_id', authenticated()->employee->division_id);
    }

    public function scopeToday($query)
    {
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();

        return $query->whereIn('created_at', [$start, $end]);
    }

    public function getQrAttribute()
    {
        return Carbon::parse($this->created_at)->format('Ymd') . $this->id;
    }

    public function getEncodedAttribute()
    {
        return Carbon::parse($this->created_at)->format('F d, Y h:i A');
    }

    public function encoder()
    {
        return $this->belongsTo(Employee::class, 'encoder_id');
    }

    public function liaison()
    {
        return $this->belongsTo(Employee::class, 'liaison_id');
    }

    public function division()
    {
        return $this->belongsTo(SYS_Division::class, 'division_id');
    }

    public function forms()
    {
        return $this->hasMany(Form::class, 'document_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'document_id');
    }

    public function tracks()
    {
        return $this->hasMany(Tracking::class, 'document_id');
    }

    public function latestTrack()
    {
        return $this->hasMany(Tracking::class, 'document_id')->orderByDesc('created_at')->take(1);
    }
}
