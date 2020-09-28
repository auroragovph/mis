<?php

namespace Modules\FileManagement\View;

use Illuminate\View\Component;

class TrackingTable extends Component
{

    public $size;
    public $tracks;
    public $document;


    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($size = 'md-12', $tracks, $document)
    {
        $this->size = $size;
        $this->tracks = $tracks;
        $this->document = $document;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('filemanagement::components.tracking-table');
    }
}