<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevController extends Controller
{
    
    public function __invoke(Request $request)
    {
        echo json_encode(config('app'));
    }
}
