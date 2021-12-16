<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Card extends Component
{
    public $title, $class;
    // public $title;


    /**
     * Create a new component instance.
     *
     * @return void
     */
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
        return view('components.ui.card');
    }
}
