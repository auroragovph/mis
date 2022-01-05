<?php

namespace Modules\FileManagement\core\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;


class FileManagementServiceProvider extends ServiceProvider
{

    protected string $moduleName = 'FileManagement';

    protected string $moduleNameLower = 'filemanagement';

    protected string $alias = 'fms';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMorphMap();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerBladeComponents();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
    }

    public function registerMorphMap()
    {

        Relation::enforceMorphMap([

            // PROCUREMENT
            'Purchase Request' => \Modules\FileManagement\core\Models\Procurement\PurchaseRequest::class,
            'Purchase Order' => \Modules\FileManagement\core\Models\Procurement\PurchaseOrder::class,

            // TRAVEL
            'Travel Order' => \Modules\FileManagement\core\Models\Travel\Order::class,

        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'core/Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'core/Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([ $sourcePath => $viewPath ], ['views', $this->moduleNameLower . '-module-views']);
        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $this->publishes([ $sourcePath => $viewPath ], ['views', $this->alias . '-module-views']);
        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->alias);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'resources/lang'), $this->moduleNameLower);
        }
    }

    public function registerBladeComponents()
    {
        Blade::component('fms-qr', \Modules\FileManagement\core\Views\QR::class);
        Blade::component('fms-attachments', \Modules\FileManagement\core\Views\Attachment::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
