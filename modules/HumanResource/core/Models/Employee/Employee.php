<?php

namespace Modules\HumanResource\core\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HumanResource\core\Models\Plantilla\Position;
use Modules\HumanResource\database\factories\Employee\EmployeeFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'hrm_employees';
    protected $guarded = [];

    protected $casts = [
        'name' => 'json',
        'info' => 'array',
        'employment' => 'json',
        'liaison' => 'boolean',
        'properties' => 'json'
    ];

    protected static function newFactory()
    {
        return EmployeeFactory::new();
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }


}
