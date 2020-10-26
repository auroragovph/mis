<?php

namespace Modules\FileTracking\View;

use Illuminate\View\Component;

class TrackingTable extends Component
{

    public $size;
    public $tracks;


    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($size = 'md-12', $tracks)
    {
        $this->size = $size;
        $this->tracks = $tracks;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('filetracking::components.tracking-table');
    }
}