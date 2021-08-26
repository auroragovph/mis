<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Config;
use Modules\AwardCommittee\Entities\Procurement\Supplier;

class DevController extends Controller
{
    public function __invoke(Request $request)
    {
        dd(Supplier::factory()->count(50)->create());
    }
}
