<?php

namespace Modules\System\Http\Controllers\ACL;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $permissions = Permission::get();
        $roles = Role::get();

        return view('system::user.acl.role.index', [
            'permissions' => $permissions,
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->post('name')]);
        $role->givePermissionTo($request->post('permissions'));

        return back()->with('alert-success', 'Role has been created.');
    }
}
