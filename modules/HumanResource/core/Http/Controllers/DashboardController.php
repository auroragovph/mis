<?php

namespace Modules\HumanResource\core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('hrm::dashboard');
    }
}
