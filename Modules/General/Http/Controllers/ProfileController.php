<?php

namespace Modules\General\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\System\Entities\SYS_ActivityLog;

class ProfileController extends Controller
{
    public function index()
    {
        $logs = SYS_ActivityLog::self()->get()->take(10);

        return view('general::profile.index', [
            'logs' => $logs
        ]);
    }
}
