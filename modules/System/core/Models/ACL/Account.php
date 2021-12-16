<?php

namespace Modules\System\core\Models\ACL;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\HumanResource\core\Models\Employee\Employee;
use Modules\System\database\factories\Acl\AccountFactory;

class Account extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];
    protected $table = 'sys_account';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => 'boolean',
        'properties' => 'array'
    ];

    protected static function newFactory()
    {
        return AccountFactory::new();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
