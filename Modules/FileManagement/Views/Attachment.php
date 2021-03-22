<?php

namespace Modules\FileManagement\Views;

use Illuminate\View\Component;

class Attachment extends Component
{

    public $attachments;


    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($attachments = [])
    {
        $this->attachments = $attachments;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('filemanagement::components.attachments');
    }
}