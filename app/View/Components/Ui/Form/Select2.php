<?php

namespace App\View\Components\Ui\Form;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $label, $class, $name, $value, $required;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = '', $class = null)
    {
        $this->label = $label;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.form.select2');
    }
}
