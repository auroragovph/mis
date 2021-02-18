<?php

namespace Modules\General\Http\Controllers;

use Illuminate\Routing\Controller;

class ActivityLogsController extends Controller
{
    public function __invoke()
    {
        return view('general::logs');
    }
}
