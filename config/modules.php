<?php

use Nwidart\Modules\Activators\FileActivator;

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
     */

    'namespace'       => 'Modules',

    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
     */

    'stubs'           => [
        'enabled'      => true,
        'path'         => base_path('stubs/modules'),
        'files'        => [
            'routes/web'       => 'routes/web.php',
            'routes/api'       => 'routes/api.php',

            'views/index'      => 'resources/views/index.blade.php',
            'views/navigation' => 'resources/views/layouts/navigation.blade.php',
            'views/master'     => 'resources/views/layouts/master.blade.php',

            'scaffold/config'  => 'core/Config/config.php',
            // 'composer'        => 'composer.json',
            // 'assets/js/app'   => 'resources/assets/js/app.js',
            // 'assets/sass/app' => 'resources/assets/sass/app.scss',
            // 'webpack'         => 'webpack.mix.js',
            // 'package'         => 'package.json',
        ],

        'replacements' => [
            'routes/web'      => ['LOWER_NAME', 'STUDLY_NAME'],
            'routes/api'      => ['LOWER_NAME'],
            'webpack'         => ['LOWER_NAME'],
            'json'            => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index'     => ['LOWER_NAME'],
            'views/master'    => ['LOWER_NAME', 'STUDLY_NAME'],
            'scaffold/config' => ['STUDLY_NAME'],
            'composer'        => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
            ],
        ],
        'gitkeep'      => false,
    ],
    'paths'           => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
         */

        'modules'   => base_path('modules'),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
         */

        'assets'    => public_path('modules'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
         */

        'migration' => base_path('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
         */
        'generator' => [

            // CORE
            'controller'      => ['path' => 'core/Http/Controllers', 'generate' => true],
            'model'           => ['path' => 'core/Models', 'generate' => true],
            'config'          => ['path' => 'core/Config', 'generate' => true],
            'command'         => ['path' => 'core/Console', 'generate' => true],

            'filter'          => ['path' => 'core/Http/Middleware', 'generate' => true],
            'request'         => ['path' => 'core/Http/Requests', 'generate' => true],
            'resource'        => ['path' => 'core/Http/Resources', 'generate' => false],

            'provider'        => ['path' => 'core/Providers', 'generate' => true],
            'repository'      => ['path' => 'core/Repositories', 'generate' => false],
            'event'           => ['path' => 'core/Events', 'generate' => false],
            'listener'        => ['path' => 'core/Listeners', 'generate' => false],
            'policies'        => ['path' => 'core/Policies', 'generate' => false],
            'rules'           => ['path' => 'core/Rules', 'generate' => false],
            'jobs'            => ['path' => 'core/Jobs', 'generate' => false],
            'emails'          => ['path' => 'core/Emails', 'generate' => false],
            'notifications'   => ['path' => 'core/Notifications', 'generate' => false],
            'component-class' => ['path' => 'core/View/Component', 'generate' => false],

            //DATABASE'
            'migration'       => ['path' => 'database/migrations', 'generate' => true],
            'seeder'          => ['path' => 'database/seeders', 'generate' => true],
            'factory'         => ['path' => 'database/factories', 'generate' => true],

            // ROUTES
            'routes'          => ['path' => 'routes', 'generate' => true],

            // RESOURCES
            'assets'          => ['path' => 'resources/assets', 'generate' => false],
            'lang'            => ['path' => 'resources/lang', 'generate' => false],
            'views'           => ['path' => 'resources/views', 'generate' => true],
            'component-view'  => ['path' => 'resources/components', 'generate' => false],

            // TEST
            'test'            => ['path' => 'tests/Unit', 'generate' => true],
            'test-feature'    => ['path' => 'tests/Feature', 'generate' => true],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Package commands
    |--------------------------------------------------------------------------
    |
    | Here you can define which commands will be visible and used in your
    | application. If for example you don't use some of the commands provided
    | you can simply comment them out.
    |
     */
    'commands'        => [
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        DisableCommand::class,
        DumpCommand::class,
        EnableCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
        InstallCommand::class,
        ListCommand::class,
        ModuleDeleteCommand::class,
        ModuleMakeCommand::class,
        FactoryMakeCommand::class,
        PolicyMakeCommand::class,
        RequestMakeCommand::class,
        RuleMakeCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class,
        MigrateResetCommand::class,
        MigrateRollbackCommand::class,
        MigrateStatusCommand::class,
        MigrationMakeCommand::class,
        ModelMakeCommand::class,
        PublishCommand::class,
        PublishConfigurationCommand::class,
        PublishMigrationCommand::class,
        PublishTranslationCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        SetupCommand::class,
        UnUseCommand::class,
        UpdateCommand::class,
        UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
        LaravelModulesV6Migrator::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
     */

    'scan'            => [
        'enabled' => false,
        'paths'   => [
            base_path('vendor/*/*'),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Composer File Template
    |--------------------------------------------------------------------------
    |
    | Here is the config for composer.json file, generated by this package
    |
     */

    'composer'        => [
        'vendor' => 'nwidart',
        'author' => [
            'name'  => 'Nicolas Widart',
            'email' => 'n.widart@gmail.com',
        ],
    ],

    'composer-output' => false,

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
     */
    'cache'           => [
        'enabled'  => false,
        'key'      => 'laravel-modules',
        'lifetime' => 60,
    ],
    /*
    |--------------------------------------------------------------------------
    | Choose what laravel-modules will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
     */
    'register'        => [
        'translations' => true,
        /**
         * load files on boot or register method
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files'        => 'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
     */
    'activators'      => [
        'file' => [
            'class'          => FileActivator::class,
            'statuses-file'  => base_path('modules_statuses.json'),
            'cache-key'      => 'activator.installed',
            'cache-lifetime' => 604800,
        ],
    ],

    'activator'       => 'file',
];
