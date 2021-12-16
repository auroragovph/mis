<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\System\core\Models\Office;

class DevController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        dd(authenticated('name'));
    }
}
