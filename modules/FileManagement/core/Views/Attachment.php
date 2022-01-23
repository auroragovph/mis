<?php

namespace Modules\FileManagement\core\Views;

use Illuminate\View\Component;

class Attachment extends Component
{

    public $attachments;
    public $forms;


    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($attachments = [], $forms = [])
    {
        $this->attachments = $attachments;
        $this->forms = $forms;
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
