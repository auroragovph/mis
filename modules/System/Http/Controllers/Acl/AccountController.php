<?php

namespace Modules\System\Http\Controllers\Acl;

use Illuminate\Routing\Controller;
use Modules\System\Entities\Account;

class AccountController extends Controller
{
    public function index()
    {

        $accounts = Account::with('employee', 'roles')->get();

        return view('system::acl.accounts.index', compact('accounts'));
    }
}
