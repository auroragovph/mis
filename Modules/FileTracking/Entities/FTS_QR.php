<?php

namespace Modules\FileTracking\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FileTracking\Database\factories\FTSQRFactory;

class FTS_QR extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'fts_qr';
    protected $casts = [
        'status' => 'boolean'
    ];
    
    protected static function newFactory()
    {
        return FTSQRFactory::new();
    }

    public function getSeriesAttribute()
    {
        return fts_series($this->id, 'encode');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', false)->get();
    }

    public static function used($id)
    {
        $qr = static::find($id);
        $qr->status = true;
        $qr->save();

        return $qr;
    }
}
