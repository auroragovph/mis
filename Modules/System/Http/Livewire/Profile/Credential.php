<?php

namespace Modules\System\Http\Livewire\Profile;

use Livewire\Component;

class Credential extends Component
{

    public $password_old, $password, $password_confirmation;

    protected $rules = [
        'password'              => ['required'],
        'password_old'          => ['required', 'confirmed'],
        'password_confirmation' => ['required']
    ];

    public function mount()
    {
        $this->password_old = null;
        $this->password = null;
        $this->password_confirmation = null;
    }
    
    public function render()
    {
        return view('system::livewire.profile.credential');
    }

    public function update()
    {
        $this->dispatchBrowserEvent('toastr-alert', [
            'type' => 'success',
            'message' => 'HEY!',
            'title' => 'Success!'
        ]);
        
    }
}
