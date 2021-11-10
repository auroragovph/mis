<?php

namespace App\View\Components\Ui\Form;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Choices extends Component
{
    public $label, $class, $rand;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = '', $class = null)
    {
        $this->label = $label;
        $this->class = $class;
        $this->rand = Str::random(10);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.form.choices');
    }
}
