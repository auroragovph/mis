<?php

namespace Modules\System\Entities\Office;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Database\factories\OfficeFactory;
use Modules\HumanResource\Entities\Employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'sys_office';

    protected static function newFactory()
    {
        return OfficeFactory::new();
    }

    public function divisions()
    {
        return $this->hasMany(SYS_Division::class, 'office_id', 'id');
    }

    public function head()
    {
        return $this->belongsTo(Employee::class, 'head_id', 'id');
    }
}
