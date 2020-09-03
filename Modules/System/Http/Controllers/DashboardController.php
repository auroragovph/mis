<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('system::dashboard.index');
    }
}
