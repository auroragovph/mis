<?php

namespace Modules\System\Http\Controllers\Acl;

use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $perms = Permission::with('roles', 'users')->orderBy('name')->get();

        return view('system::acl.permission.index', compact('perms'));
    }
}
