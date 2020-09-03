<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('system::home');
    }
}
