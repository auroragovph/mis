<?php 

namespace Modules\HumanResource\Traits\Relationship;

use Modules\System\Entities\Account;
use Modules\HumanResource\Entities\HR_Plantilla;
use Modules\System\Entities\Office\SYS_Division;

trait EmployeeRelationship{
    
    public function division()
    {
        return $this->belongsTo(SYS_Division::class, 'division_id', 'id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'employee_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(HR_Plantilla::class, 'position_id', 'id');
    }
}