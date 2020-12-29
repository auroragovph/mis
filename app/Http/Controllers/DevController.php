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
        $file = base_path()."/database/seeds/sys/accounts.json";
        $accounts = collect(json_decode(file_get_contents($file), true))->map(function($item, $key){
            $item['password'] = bcrypt($item['password']);
            return $item;
        });

        dd($accounts);
    }
}
