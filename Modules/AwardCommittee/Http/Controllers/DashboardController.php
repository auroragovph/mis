<?php

namespace Modules\AwardCommittee\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
  public function __invoke()
  {
    return view('bac::dashboard');
  }
}
