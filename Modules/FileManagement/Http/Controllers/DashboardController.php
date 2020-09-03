<?php

namespace Modules\FileManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\HumanResource\Entities\HR_Employee;

class DashboardController extends Controller
{
    public function index()
    {
        $counts['documents'] = FMS_Document::where('division_id', Auth::user()->employee->division_id)->get()->count();
        $counts['employees'] = FMS_Document::where('division_id', Auth::user()->employee->division_id)->get()->count();
        return view('filemanagement::dashboard.index', compact($counts));
    }
}
