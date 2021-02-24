<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ModuleController extends Controller
{
    public function __invoke()
    {
        return view('system::modules._index');
    }
}
