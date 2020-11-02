<?php

namespace Modules\FileTracking\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\System\Entities\SYS_User;

class FTS_DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
