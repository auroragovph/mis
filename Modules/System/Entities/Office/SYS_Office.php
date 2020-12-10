<?php

namespace Modules\System\Entities\Office;

use Illuminate\Database\Eloquent\Model;

class SYS_Office extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    
    protected $guarded = [];
    protected $table = 'sys_office';

    public function divisions()
    {
        return $this->hasMany(SYS_Division::class, 'office_id', 'id');
    }
}
