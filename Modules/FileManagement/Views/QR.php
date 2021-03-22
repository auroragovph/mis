<?php

namespace Modules\FileManagement\Views;

use Illuminate\View\Component;

class QR extends Component
{
    public $document;
    public $datas;


    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($document, $datas = [])
    {
        $this->document = $document;
        $this->datas = $datas;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('filemanagement::components.qr');
    }
}