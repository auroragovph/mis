<?php

namespace Modules\System\Http\Controllers\ACL;

use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->sortBy('name');
        
        return view('system::user.acl.permission.index', [
            'permissions' => $permissions
        ]);
    }
}
