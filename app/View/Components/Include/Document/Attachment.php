<?php

namespace App\View\Components\Include\Document;


use Illuminate\View\Component;

class Attachment extends Component
{

    public function __construct(
      public mixed $attachments = [],
      public mixed $forms = []
      )
    {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.include.document.attachment');
    }
}
