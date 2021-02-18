<?php

namespace Modules\General\Http\Controllers;

use Illuminate\Routing\Controller;

class MessengerController extends Controller
{
    public function index()
    {
        return view('general::messenger');
    }

    public function show($id)
    {

    }

    public function send()
    {

    }
}
