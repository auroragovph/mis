<?php

namespace App\View\Components\Include\Document;

use Illuminate\View\Component;
use App\Models\Document\Series;

class Qr extends Component
{
    public function __construct(
      public Series $series,
      public array $datas = []
    )
    {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.include.document.qr');
    }
}
