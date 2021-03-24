<?php

namespace App\View\Components\Ui\Form;

use Illuminate\View\Component;

class TextArea extends Component
{
    public $label, $size, $class, $name, $value, $required;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name, 
        $label = '',
        $class = null,
        $value = null, 
        $required = false, 
        $size = [10,2]
    ){
        $this->label = $label;
        $this->class = $class;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->size = $size;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.form.text-area');
    }
}
