<?php

namespace Modules\System\Http\Controllers\Acl;

use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {

        $roles = Role::with('permissions', 'users')->get();

        return view('system::acl.role.index', compact('roles'));
    }
}
