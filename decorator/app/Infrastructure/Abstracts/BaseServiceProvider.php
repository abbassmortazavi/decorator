<?php

namespace App\Infrastructure\Abstracts;

use App\Infrastructure\Support\Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use ReflectionClass;

abstract class BaseServiceProvider extends LaravelServiceProvider
{

    /**
     * @var string Alias for load translations and views
     */
    protected string $alias;


    /**
     * @var bool Set if will load commands
     */
    protected bool $hasCommands = false;


    /**
     * @var bool Set if will load migrations
     */
    protected bool $hasMigrations = false;


    /**
     * @var bool Set if will load config
     */
    protected bool $hasConfig = false;


    /**
     * @var bool Set if will load translations
     */
    protected bool $hasTranslations = false;

    /**
     * @var bool Set if will load views
     */
    protected bool $hasViews = false;


    /**
     * @var bool Set if will load helper
     */
    protected bool $hasHelper = false;


    /**
     * @var bool Set if will load policies
     */
    protected bool $hasPolicies = false;


    /**
     * @var bool Set if will load observer
     */
    protected bool $hasObserver = false;


    /**
     * @var bool Set if will load facade
     */
    protected bool $hasFacade = false;

    /**
     * @var bool Set if will load blade extensions
     */
    protected bool $hasBladeExtensions = false;


    /**
     * @var array List of custom Artisan commands
     */
    protected array $commands = [];


    /**
     * @var array List of providers to load
     */
    protected array $providers = [];


    /**
     * @var array List of policies to load
     */
    protected array $policies = [];


    /**
     * @var array List of observer to load
     */
    protected array $observers = [];


    /**
     * @var array List of facades to load
     */
    protected array $facades = [];


    /**
     * Boot required registering of views and translations.
     *
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerCommands();
        $this->registerMigrations();
        $this->registerConfig();
        $this->registerTranslations();
        $this->registerViews();
        $this->registerHelpers();
    }


    /**
     * Detects the domain base path so resources can be proper loaded on child classes.
     *
     * @param null $append
     * @return string
     */
    protected function domainPath($append = null): string
    {
        $reflection = new ReflectionClass($this);

        $realPath = realpath(dirname($reflection->getFileName()) . '/../');

        if (!$append) {
            return $realPath;
        }

        return $realPath . '/' . $append;
    }


    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        if ($this->hasPolicies && config('register.policies')) {
            foreach ($this->policies as $key => $value) {
                Gate::policy($key, $value);
            }
        }
    }


    /**
     * Register domain custom Artisan commands.
     */
    protected function registerCommands()
    {
        if ($this->hasCommands && config('register.commands')) {
            $this->commands($this->commands);
        }
    }


    /**
     * Register domain migrations.
     *
     */
    protected function registerMigrations()
    {
        if ($this->hasMigrations && config('register.migrations')) {
            $this->loadMigrationsFrom($this->domainPath('Database/Migrations'));
        }
    }


    /**
     * Register domain config
     *
     */
    protected function registerConfig()
    {
        if ($this->hasConfig && config('register.config')) {
            $path = base_path('app/Domain/*/Config/*.php');
            $configs = Helper::loadModuleConfigV2($path);
            foreach ($configs as $key => $row) {
                $this->mergeConfigFrom($row, $key);
            }
        }
    }


    /**
     * Register domain translations.
     */
    protected function registerTranslations()
    {
        if ($this->hasTranslations && config('register.translations')) {
            $this->loadJsonTranslationsFrom($this->domainPath('Resources/Lang'));
            $this->loadTranslationsFrom($this->domainPath('Resources/Lang'), $this->alias);
        }
    }


    /**
     * Register domain views.
     */
    protected function registerViews()
    {
        if ($this->hasViews && config('register.views')) {
            $this->loadViewsFrom($this->domainPath('Resources/Views'), $this->alias);
        }
    }


    /**
     * Register domain helper.
     */
    protected function registerHelpers()
    {
        if ($this->hasHelper && config('register.helper')) {
            Helper::loadModuleHelpersV2();
        }
    }


    /**
     * Register Domain ServiceProviders.
     */
    public function register()
    {
        collect($this->providers)->each(function ($providerClass) {
            $this->app->register($providerClass);
        });

        $this->bindFacades();
    }


    /**
     * Bind Facades.
     *
     * @return void
     */
    private function bindFacades()
    {
        // bind the postData Facade
        foreach ($this->facades as $key => $facade) {
            $this->app->bind($key, static function () use ($facade) {
                return new $facade;
            });
        }

    }



//    private function publishResources()
//    {
//        /**
//         * publish config file to config folder
//         * in everywhere: config('post.names')
//         */
//        $this->publishes([__DIR__ . '/../Config' => base_path('config')], 'config');
//
//        /**
//         * publish database files to database folder
//         * in command: php artisan migrate
//         */
//        $this->publishes([
//            __DIR__ . '/../Database' => base_path('database'),
//        ], 'database');
//
//        /**
//         * publish language files to resources/lang folder
//         */
//        /*$this->publishes([
//            __DIR__ . '/../../resources/lang' => base_path('/resources/lang/post'),
//        ], 'lang');*/
//
//        /**
//         * publish views files to resources/views folder
//         * usage in controller : view('post.admin.index')
//         */
//        /*$this->publishes([
//            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/post',
//        ], 'views');*/
//
//    }

}
