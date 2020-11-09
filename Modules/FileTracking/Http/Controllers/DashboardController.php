<?php

namespace Modules\FileTracking\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\HumanResource\Entities\HR_Employee;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $datas['qr'] = FTS_Qr::available()->count();
        $datas['documents'] = FTS_Document::count();
        $datas['employees'] = HR_Employee::count();
        $datas['liaisons'] = HR_Employee::liaison()->count();

        return view('filetracking::dashboard.index', compact("datas"));
    }

    
}
