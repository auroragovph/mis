<?php

namespace App\View\Components\Ui\Widget;

use Illuminate\View\Component;

class Simple extends Component
{
    public $color, $title, $desc;
    
    public function __construct($title, $desc, $color = 'bg-info')
    {
        $this->title = $title;
        $this->desc = $desc;
        $this->color = $color;
    }

    
    public function render()
    {
        return view('components.ui.widget.simple');
    }
}
