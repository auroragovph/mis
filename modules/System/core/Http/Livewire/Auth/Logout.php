<?php

namespace Modules\System\core\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect(route('home'));
    }


    public function render()
    {
        return <<<'blade'
            <a href="#" wire:click="logout" class="dropdown-item">Logout</a>
        blade;
    }
}
