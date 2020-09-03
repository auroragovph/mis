<?php

namespace Modules\System\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;




class SignInController extends Controller
{
   
    use ThrottlesLogins;

    protected $maxAttempts = 3;
    protected $decayMinutes = 1;
    protected $username = 'username';

    public function form()
    {

        // checking if already login
        if(Auth::check()){
            return redirect('/home');
        }

        return view('system::auth.signin');
    }

    public function username()
    {
        return $this->username;
    }

    public function authenticate(Request $request)
    {
        if(Auth::check()){
            $response['message'] = 'Already authenticated';
            return response()->json($response, 400);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }



        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1])) {
            $this->clearLoginAttempts($request);
            return response()->json(['message' => 'Success Login'], 200);
        }

        $this->incrementLoginAttempts($request);

        return response()->json(['message' => 'We cannot find your credentials in our database.'], 406);
    }

    public function logout()
    {
        if(Auth::check()){
           Auth::logout();
        }

        return redirect('auth/signin');
    }
}
