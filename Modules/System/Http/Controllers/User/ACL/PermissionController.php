<?php

namespace Modules\System\Http\Controllers\User\ACL;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        
    }

    public function store(Request $request)
    {
        $module = $request->module;
        $name = str_replace(' ', '.', $request->name);
        $perm = Permission::create(['name' => $module.'.'.$name]);

        return redirect(route('sys.user.acl.index'))->with('alert-success', 'Permission has been created.');

    }
}
