<?php

namespace Modules\System\Http\Livewire\Profile;

use Livewire\Component;
use Modules\System\Entities\ActivityLog;
use Whoops\RunInterface;

class Logs extends Component
{

    public $logs;
    public $take = 0;
    public $count_logs = 0;

    public function mount()
    {
        $this->loadData();
        $this->count_logs = $this->count_logs();
    }

    public function render()
    {
        return view('system::livewire.profile.logs');
    }

    public function loadData()
    {
        $this->take += 10;
        $this->logs = $this->fetch();
    }

    public function fetch()
    {
        return ActivityLog::where('employee_id', auth()->user()->employee_id)
        ->orderBy('created_at', 'DESC')
        ->take($this->take)
        ->get();
    }

    public function count_logs()
    {
        return ActivityLog::where('employee_id', auth()->user()->employee_id)
                                ->count();
    }
}
