<?php

namespace Modules\FileManagement\Entities\Travel;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;

class FMS_TravelOrder extends Model
{

    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    use LogsActivity;
        
    protected $guarded = [];
    protected $table = 'fms_form_travel_order';

    protected $casts = [
        'lists' => 'json'
    ];

    protected static $logName = 'fms';
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['updated'];


    public function getDescriptionForEvent(string $eventName): string
    {
        return "Travel order has been {$eventName}";
    }


    public function charging()
    {
        return $this->belongsTo(SYS_Division::class, 'charging_id', 'id');
    }

    public function approval()
    {
        return $this->belongsTo(HR_Employee::class, 'approval_id', 'id');
    }

    public function employees()
    {
        return $this->belongsToJson(HR_Employee::class, 'lists', 'id');
    }


}
