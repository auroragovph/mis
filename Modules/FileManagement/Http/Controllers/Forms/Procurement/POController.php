<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Routing\Controller;

class POController extends Controller
{
    public function index()
    {
        return view('filemanagement::forms.procurement.order.index');
    }
}
