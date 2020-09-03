<?php

namespace Modules\System\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class SYS_User extends Authenticatable
{
    use SoftDeletes;
    use HasRoles;
    
    protected $guarded = [];
    protected $table = 'sys_users';


    public function employee()
    {
        return $this->belongsTo('Modules\HumanResource\Entities\HR_Employee', 'employee_id');
    }
}
