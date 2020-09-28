<?php

namespace Modules\FileManagement\Entities\Cafoa;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;

class FMS_Cafoa extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    
    protected $guarded = [];
    protected $table = 'fms_form_cafoa';
    protected $casts = [
        'lists' => 'collection',
        'ledger' => 'collection',
        'signatories' => 'json'
    ];


    public function requesting()
    {
        return $this->belongsTo(HR_Employee::class, 'requesting_id', 'id');
    }

    public function budget()
    {
        return $this->belongsTo(HR_Employee::class, 'signatories->budget->id', 'id');
    }

    public function accounting()
    {
        return $this->belongsTo(HR_Employee::class, 'signatories->accounting->id', 'id');
    }

    public function treasury()
    {
        return $this->belongsTo(HR_Employee::class, 'signatories->treasury->id', 'id');
    }
}
