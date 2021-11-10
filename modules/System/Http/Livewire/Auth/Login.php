<?php

namespace Modules\System\Http\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{
    public $name, $password;

    public function render()
    {
        return view('system::livewire.auth.login')->layout('layouts.tabler.clean');
    }

    public function login()
    {

    }

    public function authenticate()
    {

    }
}
