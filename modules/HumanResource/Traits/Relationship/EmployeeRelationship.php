<?php 

namespace Modules\HumanResource\Traits\Relationship;

use Modules\HumanResource\Entities\Employee\Position;
use Modules\System\Entities\Account;
use Modules\System\Entities\Office\Division;

trait EmployeeRelationship{
    
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'employee_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
}