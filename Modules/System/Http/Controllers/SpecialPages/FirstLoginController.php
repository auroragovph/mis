<?php

namespace Modules\System\Http\Controllers\SpecialPages;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Http\Requests\Specials\FirstLoginRequest;

class FirstLoginController extends Controller
{
    public function index()
    {
        return view('system::special-pages.login.first.index');
    }

    public function submit(FirstLoginRequest $request, HR_Employee $employee)
    {
         // checking if request has file
         if($request->hasFile('profile_avatar')){

            $file = $request->file('profile_avatar');
            $path = $file->store('public/employees/profile');
            $image_name = str_replace('public/employees/profile/', '', $path);

            $current_image = $employee->info['image'];

            if($current_image != null){
                unlink(storage_path("app/public/employees/profile/".$current_image));
            }

        }else{
            $image_name = $employee->info['image'];
        }

        $employee->update([
            'name->fname' => $request->post('firstname'),
            'name->lname' => $request->post('lastname'),
            'name->mname' => $request->post('middlename'),
            'name->sname' => $request->post('namesuffix'),
            'name->title' => $request->post('nametitle'),

            'info->gender' => $request->post('sex'),
            'info->birthday' => $request->post('birthday'),
            'info->address' => $request->post('address'),
            'info->civilStatus' => $request->post('civil'),
            'info->phoneNumber' => $request->post('phone'),
            'info->image' => $image_name,


            'division_id' => $request->post('division'),
            'position_id' => $request->post('position'),
            'card' => $request->post('card'),

            'employment->type' => $request->post('appointment'),

            'liaison' => ($request->has('liaison')) ? true : false,

        ]);

        // updating account
        $properties = $employee->account->properties;
        unset($properties['auth']['firstLogin']);

        $employee->account()->update([
            'username' => $request->post('username'),
            'password' => Hash::make($request->post('password')),
            'properties' => $properties
        ]);

        return response()->json(['message' => 'Employee has been updated', 'route' => route('dashboard')]);
    }
}
