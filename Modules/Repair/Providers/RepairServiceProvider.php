<?php

namespace Modules\Repair\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Utils\ModuleUtil;
use App\Utils\Util;

class RepairServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->registerScheduleCommands();

        //TODO:Remove sidebar
        view::composer(['repair::layouts.partials.sidebar',
            'repair::layouts.partials.invoice_layout_settings',
            'repair::layouts.partials.pos_header',
            'repair::layouts.partials.header',
        ], function ($view) {
            if (auth()->user()->can('superadmin')) {
                $__is_repair_enabled = true;
            } else {
                $business_id = session()->get('user.business_id');
                $module_util = new ModuleUtil();
                $__is_repair_enabled = (bool) $module_util->hasThePermissionInSubscription($business_id, 'repair_module');
            }

            $view->with(compact('__is_repair_enabled'));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->registerCommands();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('repair.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php',
            'repair'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/repair');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/repair';
        }, \Config::get('view.paths')), [$sourcePath]), 'repair');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/repair');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'repair');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'repair');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
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

    /**
     * Register commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        
    }

    public function registerScheduleCommands()
    {

    }
}