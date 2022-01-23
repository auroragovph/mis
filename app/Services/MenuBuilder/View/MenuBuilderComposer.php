<?php

namespace App\Services\MenuBuilder\View;

use App\Services\MenuBuilder\MenuBuilder;
use Illuminate\View\View;

class MenuBuilderComposer
{
    private $menu_builder;

    public function __construct(MenuBuilder $menu_builder)
    {
        $this->menu_builder = $menu_builder;
    }

    public function compose(View $view)
    {
        $view->with('menu_builder', $this->menu_builder);
    }
}
