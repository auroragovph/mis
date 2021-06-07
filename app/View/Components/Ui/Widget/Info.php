<?php

namespace App\View\Components\Ui\Widget;

use Illuminate\View\Component;

class Info extends Component
{
    public $color, $icon, $title, $desc;
    
    public function __construct($title, $desc, $color = 'bg-info', $icon = 'fas fa-user')
    {
        $this->title = $title;
        $this->desc = $desc;
        $this->color = $color;
        $this->icon = $icon;
    }

    
    public function render()
    {
        return view('components.ui.widget.info');
    }
}
