<?php

namespace Modules\HumanResource\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('humanresource::dashboard');
    }
}
