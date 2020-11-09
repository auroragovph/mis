<?php

namespace Modules\System\Http\Controllers\SpecialPages;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\System\Entities\SYS_User;

class SP_LoginController extends Controller
{
    public function first(Request $request)
    {
        if(!array_key_exists('firstLogin', auth()->user()->properties['auth'])){return abort(404);}   


        if($request->method() == 'POST'){

            $employee = HR_Employee::find(auth()->user()->employee_id);
            $employee->update([

                'name->fname' => ucnames($request->post('fname')),
                'name->lname' => ucnames($request->post('lname')),
                'name->mname' => ucnames($request->post('mname')),
                'name->sname' => ucnames($request->post('sname')),
                'name->title' => ucnames($request->post('title')),

                'info->gender' => $request->post('gender'),
                'info->birthday' => $request->post('birthday'),
                'info->address' => $request->post('address'),
                'info->civilStatus' => $request->post('civil'),
                'info->phoneNumber' => $request->post('phone'),

                'employment->type' => $request->post('employment-type'),

                'card' => $request->post('card') ?? '',

                'division_id' => $request->post('division'),
                'position_id' => $request->post('position')

            ]);

            $user = SYS_User::find(auth()->user()->id);
            $user->password = password_hash(session()->pull('sys.password'), PASSWORD_BCRYPT);
            $properties = $user->properties;
            unset($properties['auth']['firstLogin']);
            $user->properties = $properties;
            $user->save();

            session()->flash('alert-success', 'Profile has been updated.');
            return response()->json(['message' => 'Profile has been updated.', 'route' => route('fts.dashboard')], 200);
        }

        $divisions = SYS_Division::lists();        
        return view('system::special-pages.login.first',[
            'divisions' => $divisions
        ]);
    }
}
