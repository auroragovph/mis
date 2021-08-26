<?php

namespace Modules\FileManagement\Entities\Document;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Office\Division;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\FileManagement\Entities\Document\Form;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\FileManagement\Traits\Documents\Relationships;

class Document extends Model
{
    use SoftDeletes, Relationships;

    protected $guarded = [];
    protected $table = 'fms_documents';
    protected $casts = [
        'properties' => 'json',
        'status' => 'integer',
    ];

   
    /**
     * Store directly in the database
     * @param int $liaison
     * @param int $type
     * @param string $particulars
     * @return $this
     */
    public static function directStore(int $liaison, int $type): self
    {
        return static::create([
            'division_id' => authenticated()->employee->division_id,
            'liaison_id' => $liaison,
            'encoder_id' => authenticated()->employee_id,
            'type' => $type
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
        return 'FMS-'.Carbon::parse($this->created_at)->format('Ymd') . $this->id;
    }

    public function getQrcodeAttribute()
    {
        return $this->getQrAttribute();
    }

    public function getEncodedAttribute()
    {
        return Carbon::parse($this->created_at)->format('F d, Y h:i A');
    }

    public function getCardInfoAttribute()
    {
        $ids = [$this->liaison_id, $this->encoder_id];
        $employees = Employee::whereIn('id', $ids)->get();

        $details = [
            'encoder' => $employees->where('id', $this->encoder_id)->first(),
            'liaison' => $employees->where('id', $this->liaison_id)->first(),
        ];

        return $details;

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
        return $this->belongsTo(Division::class, 'division_id');
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
        return $this->hasMany(Track::class, 'document_id');
    }

    public function latestTrack()
    {
        return $this->hasMany(Track::class, 'document_id')->orderByDesc('created_at')->take(1);
    }
}
