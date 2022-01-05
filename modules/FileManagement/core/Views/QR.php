<?php

namespace Modules\FileManagement\core\Views;

use Illuminate\View\Component;

class QR extends Component
{
    public $series;
    public $datas;


    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($series, $datas = [])
    {
        $this->series = $series;
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
