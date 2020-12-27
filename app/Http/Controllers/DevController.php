<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use EmployeeFactory;
use Spatie\Permission\Models\Role;

class DevController extends Controller
{
    public function index()
    {
        // dd(\Modules\HumanResource\Entities\HR_Employee::newFactory());

        $role = Role::create(['name' => 'SA']);
        $role->givePermissionTo(['fts.sa.*', 'fts.document.*']);

        dd($role->hasPermissionTo('fts.sa.qr'));

    }
}
