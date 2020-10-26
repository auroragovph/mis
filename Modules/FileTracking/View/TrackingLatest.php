<?php

namespace Modules\FileTracking\View;

use Illuminate\View\Component;

class TrackingLatest extends Component
{

    public $size;
    public $track;


    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($size = 'md-12', $track)
    {
        $this->size = $size;
        $this->track = $track;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('filetracking::components.tracking-latest');
    }
}