<?php

namespace App\Services\MenuBuilder;


use App\Services\MenuBuilder\Menu\Builder;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;
use App\Services\MenuBuilder\Events\BuildingMenu;
use App\Services\MenuBuilder\Helpers\SidebarItemHelper;

class MenuBuilder
{
    /**
     * The array of menu items.
     *
     * @var array
     */
    protected $menu;

    /**
     * The array of menu filters. These filters will apply on each one of the
     * menu items in order to transforms they in some way.
     *
     * @var array
     */
    protected $filters;

    /**
     * The events dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * The application service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Map between a valid menu filter token and his respective filter method.
     * These filters are intended to get a specific set of menu items.
     *
     * @var array
     */
    protected $menuFilterMap;

    /**
     * Constructor.
     *
     * @param  array  $filters
     * @param  Dispatcher  $events
     * @param  Container  $container
     */
    public function __construct(Dispatcher $events, Container $container)
    {
        $this->filters = [
            \App\Services\MenuBuilder\Menu\Filters\GateFilter::class,
            \App\Services\MenuBuilder\Menu\Filters\HrefFilter::class,
            \App\Services\MenuBuilder\Menu\Filters\ActiveFilter::class,
            \App\Services\MenuBuilder\Menu\Filters\ClassesFilter::class,
        ];
        $this->events = $events;
        $this->container = $container;

        // Fill the map of filters methods.

        $this->menuFilterMap = [
            'sidebar'      => [$this, 'sidebarFilter'],
        ];
    }

    /**
     * Get all the menu items, or a specific set of these.
     *
     * @param  string  $filterToken  Token representing a subset of the menu items
     * @return array A set of menu items
     */
    public function menu($filterToken = null)
    {
        if (empty($this->menu)) {
            $this->menu = $this->buildMenu();
        }

        // Check for filter token.

        if (isset($this->menuFilterMap[$filterToken])) {
            return array_filter(
                $this->menu,
                $this->menuFilterMap[$filterToken]
            );
        }

        // No filter token provided, return the complete menu.

        return $this->menu;
    }

    /**
     * Build the menu.
     *
     * @return array The set of menu items
     */
    protected function buildMenu()
    {
        // Create the menu builder instance.

        $builder = new Builder($this->buildFilters());

        // Dispatch the BuildingMenu event. Listeners of this event will fill
        // the menu.

        $this->events->dispatch(new BuildingMenu($builder));

        // Return the set of menu items.

        return $builder->menu;
    }

    /**
     * Build the menu filters.
     *
     * @return array The set of filters that will apply on each menu item
     */
    protected function buildFilters()
    {
        return array_map([$this->container, 'make'], $this->filters);
    }

    /**
     * Filter method used to get the sidebar menu items.
     *
     * @param  mixed  $item  A menu item
     * @return bool
     */
    private function sidebarFilter($item)
    {
        return SidebarItemHelper::isValidItem($item);
    }
}
