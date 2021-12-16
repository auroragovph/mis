<?php

namespace Modules\System\core\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Modules\System\core\Models\ACL\Account;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $username, $password;

    protected $rules = [
        'username' => 'required',
        'password' => 'required',
    ];

    public function login()
    {
        $validated = $this->validate();

        if (! Auth::attempt($validated)) {
            throw ValidationException::withMessages([
                // 'username' => __('auth.failed'),
                'username' => 'Authentication error. Please check your credentials.',
            ]);
        }

        session()->flash('welcome_back');
        return redirect(session()->pull('url.intended', route('home')));
    }

    public function render()
    {
        return view('sys::auth.login');
    }
}
