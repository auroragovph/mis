<?php

namespace Modules\FileManagement\core\Models\Travel;

use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\core\Traits\HasDocument;
use Modules\System\core\Models\Office;

class Order extends Model
{
    use HasDocument;

    protected $table = 'fms_travel_order';
    protected $guarded = [];

    protected $casts = [
        'departure' => 'date',
        'arrival' => 'date',
        'employees' => 'json',
        'signatories' => 'json',
        'properties' => 'array'
    ];

    public function charging()
    {
        return $this->belongsTo(Office::class, 'charging_id');
    }
}
