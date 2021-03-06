<?php

namespace Modules\Manufacturer\Providers;

use App\Providers\AuthServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class ManufacturerServiceProvider extends AuthServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \Modules\Manufacturer\Models\Manufacturer::class => \Modules\Manufacturer\Policies\ManufacturerPolicy::class,
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('modules.manufacturer' . '.php'),
        ], 'config');

        //  merge any registered relationships into the main config
        $this->mergeConfigFrom(__DIR__.'/../Config/relations.php', 'modules.relations');

        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php',
            'manufacturer'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/manufacturer');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/manufacturer';
        }, \Config::get('view.paths')), [$sourcePath]), 'manufacturer');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/manufacturer');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'manufacturer');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang/en', 'manufacturer');
        }
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
}
