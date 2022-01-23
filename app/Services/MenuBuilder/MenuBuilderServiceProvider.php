<?php

namespace App\Services\MenuBuilder;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;
use App\Services\MenuBuilder\Events\BuildingMenu;
use App\Services\MenuBuilder\View\MenuBuilderComposer;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class MenuBuilderServiceProvider extends BaseServiceProvider
{


    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        // Bind a singleton instance of the menu builder class into the service
        // container.

        $this->app->singleton(MenuBuilder::class, function (Container $app) {
            return new MenuBuilder(
                $app['events'],
                $app
            );
        });
    }

    /**
     * Bootstrap the package's services.
     *
     * @return void
     */
    public function boot(Factory $view, Dispatcher $events, Repository $config)
    {
        $this->registerMenu($events, $config);
        $this->registerViewComposers($view);

    }



    /**
     * Register the menu events handlers.
     *
     * @return void
     */
    private static function registerMenu(Dispatcher $events, Repository $config)
    {
        // Register a handler for the BuildingMenu event, this handler will add
        // the menu defined on the config file to the menu builder instance.

        $events->listen(
            BuildingMenu::class,
            function (BuildingMenu $event) use ($config) {
                $menu = $config->get('menu', []);
                $menu = is_array($menu) ? $menu : [];
                $event->menu->add(...$menu);
            }
        );
    }

    /**
     * Register the package's view composers.
     *
     * @return void
     */
    private function registerViewComposers(Factory $view)
    {
        $view->composer('metronic::v8.main', MenuBuilderComposer::class);
    }

}
