<?php

namespace App\View\Components\Ui\Table;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class DataTable extends Component
{
    public $title, $class, $rand;
    
    public function __construct($title = null, $class = null)
    {
        $this->title = $title;
        $this->class = $class;
        $this->rand = Str::random();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.table.data-table');
    }
}
