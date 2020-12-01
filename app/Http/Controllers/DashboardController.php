<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {


        switch(auth()->user()->employee->division_id){

            case config('constants.office.PTO'): 
                $view = 'dashboard.index';
            break;

            default: 
                $view = 'dashboard.index';
            break;

        }

        
        return view($view);
    }
}
