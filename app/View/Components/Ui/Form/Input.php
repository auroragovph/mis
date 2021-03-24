<?php

namespace App\View\Components\Ui\Form;

use Illuminate\View\Component;

class Input extends Component
{

    public $label, $type, $class, $name, $value, $required;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label = '', $type = 'text', $class = null, $value = null, $required = false)
    {
        $this->label = $label;
        $this->type = $type;
        $this->class = $class;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.form.input');
    }
}
