<?php

namespace Modules\FileManagement\core\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('fms::dashboard');
    }
}
