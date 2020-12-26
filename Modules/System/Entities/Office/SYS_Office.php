<?php

namespace Modules\System\Entities\Office;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Database\factories\OfficeFactory;

class SYS_Office extends Model
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
}
