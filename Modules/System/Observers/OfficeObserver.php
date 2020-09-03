<?php

namespace Modules\System\Observers;

use Modules\System\Entities\Office\SYS_Office;
use Modules\System\Entities\Office\SYS_Division;


class OfficeObserver
{
    public function created(SYS_Office $office)
    {
        SYS_Division::create([
            'name' => 'MAIN',
            'alias' => 'MAIN',
            'office_id' => $office->id
        ]);
    }
}