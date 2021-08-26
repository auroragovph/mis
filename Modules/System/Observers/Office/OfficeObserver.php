<?php

namespace Modules\System\Observers\Office;

use Modules\System\Entities\Office\Division;
use Modules\System\Entities\Office\Office;

class OfficeObserver
{
    public function created(Office $office)
    {
        $division = Division::create([
            'name' => 'MAIN',
            'head_id' => $office->head_id,
            'office_id' => $office->id
        ]);
    }
}