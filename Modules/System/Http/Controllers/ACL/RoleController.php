<?php

namespace Modules\System\Http\Controllers\ACL;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Http\Requests\ACL\RoleStoreRequest;
use Modules\System\Transformers\ACL\RoleResource;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function lists(Request $request)
    {
        $roles = ($request->has('search')) ? Role::with('permissions')->where('name', 'like', '%'.$request->input('search').'%')->get() : Role::with('permissions')->get();
        return RoleResource::collection($roles);
    }

    public function index()
    {
        $permissions = Permission::get();
        return view('system::acl.role.index', [
            'permissions' => $permissions
        ]);
    }

    public function store(RoleStoreRequest $request)
    {
        // creating role
        $permission = Role::create([
            'name' => $request->post('name')
        ]);

        // granting permissions
        $permission->syncPermissions($request->post('permissions'));

        return redirect(route('sys.acl.role.index'))->with('alert-success', 'Role has been created.');
    }
}
