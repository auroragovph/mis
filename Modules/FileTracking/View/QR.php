<?php

namespace Modules\FileTracking\View;

use Illuminate\View\Component;

class QR extends Component
{

    public $size;
    public $document;
    public $datas;


    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($size = 'sm-12', $document, $datas = null)
    {
        $this->size = $size;
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
        return view('filetracking::components.qr');
    }
}