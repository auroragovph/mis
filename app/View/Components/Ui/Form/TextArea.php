<?php

namespace App\View\Components\Ui\Form;

use Illuminate\View\Component;

class TextArea extends Component
{
    public $label, $size, $class;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $label = '',
        $size = [10,2],
        $class = ''
    ){
        $this->label = $label;
        $this->size = $size;
        $this->class = $class;

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
