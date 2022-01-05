<?php

namespace Modules\FileManagement\core\Models\Document;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\core\Models\Employee\Employee;
use Modules\System\core\Models\Office;

class Series extends Model
{
    protected $table = 'fms_document_series';
    protected $guarded = [];

    /**
     * Store directly in the database
     */
    public static function directStore(int $liaison, int $type): self
    {
        return static::create([
            'office_id' => authenticated('office_id'),
            'liaison_id' => $liaison,
            'encoder_id' => authenticated('employee_id'),
            'type' => $type
        ]);
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

    public function getQrcodeBase64Attribute()
    {
        $format = (extension_loaded('imagick')) ? 'png' : 'svg';
        $qr     = \SimpleSoftwareIO\QrCode\Facades\QrCode::format($format)
            ->size(50)
            ->margin(1.5)
            ->generate($this->getQrAttribute());

        $base64 = base64_encode($qr);

        if ($format == 'png') {
            return 'data:image/png;base64,' . $base64;
        }

        return 'data:image/svg+xml;base64,' . $base64;
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

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function encoder()
    {
        return $this->belongsTo(Employee::class, 'encoder_id');
    }

    public function liaison()
    {
        return $this->belongsTo(Employee::class, 'liaison_id');
    }

    public function forms()
    {
        return $this->hasMany(Form::class, 'series_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'series_id');
    }

    public function tracks()
    {
        return $this->hasMany(Track::class, 'series_id');
    }

    public function latestTrack()
    {
        return $this->hasMany(Track::class, 'series_id')->orderByDesc('created_at')->take(1);
    }
}
