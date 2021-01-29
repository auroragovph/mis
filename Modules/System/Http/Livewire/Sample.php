<?php

namespace Modules\System\Http\Livewire;

use Livewire\Component;

class Sample extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }
    
    public function render()
    {
        return view('system::livewire.sample');
    }
}
