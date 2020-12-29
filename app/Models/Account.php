<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\HumanResource\Entities\HR_Employee;
use Spatie\Permission\Traits\HasRoles;

class Account extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => 'boolean',
        'properties' => 'array'
    ];

    public function employee()
    {
        return $this->belongsTo(HR_Employee::class, 'employee_id', 'id');
    }
}
