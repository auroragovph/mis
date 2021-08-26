<?php

namespace App\View\Components\Ui\Table;

use Illuminate\View\Component;

class Table extends Component
{
    public $title, $class;
    
    public function __construct($title = null, $class = null)
    {
        $this->title = $title;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.table.table');
    }
}
