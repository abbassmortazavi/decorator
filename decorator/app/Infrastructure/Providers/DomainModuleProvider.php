<?php namespace App\Infrastructure\Providers;

use App\Domain\Home\Enums\OutputExport;
use App\Domain\Home\Models\Product;
use App\Infrastructure\Support\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

//use App\Infrastructure\Abstracts\ServiceProvider;


class DomainModuleProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        /**
         * Load translations
         * usage: echo trans('post::post.name');
         */
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'base');

        /**
         * publish config file to config folder
         * in everywhere: config('base.guards.user')
         */
        $this->publishes([
            __DIR__ . '/../Config' => base_path('config'),
        ], 'config');

        /**
         * Setup share variables to pass data to all views
         */
        $this->shareVariables();

        /**
         * Setup Custom validators
         */
        $this->registerValidators();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        Helper::loadModuleHelpers(__DIR__);

        $this->registerConfig();


        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);


        foreach (config('base.extra_provider', []) as $item) {
            $this->app->register($item);
        }


        foreach (config('base.extra_alias', []) as $alias => $provider) {
            $this->app->alias($alias, $provider);
        }

    }


    /**
     * Load and merge configs
     */
    public function registerConfig()
    {
        $path = base_path('app/Infrastructure/Config/*.php');
        $configs = Helper::loadModuleConfigV2($path);
        foreach ($configs as $key => $row) {
            $this->mergeConfigFrom($row, $key);
        }
    }

    /**
     * Register Custom Validators
     */
    private function registerValidators()
    {
        Validator::extend('custom.individual_national_id', 'App\Infrastructure\Validator\CustomValidator@isIndividualNationalId');
        Validator::extend('custom.strength_password', 'App\Infrastructure\Validator\CustomValidator@isStrengthPassword');
        Validator::extend('custom.debit_card', 'App\Infrastructure\Validator\CustomValidator@isDebitCard');
        Validator::extend('custom.subdomain', 'App\Infrastructure\Validator\CustomValidator@isValidSubdomain');
        Validator::extend('custom.without_spaces', 'App\Infrastructure\Validator\CustomValidator@withoutSpaces');
        Validator::extend('custom.mobile', 'App\Infrastructure\Validator\CustomValidator@mobile');
        Validator::extend('custom.persian_alpha', 'App\Infrastructure\Validator\CustomValidator@isPersianAlphabets');
        Validator::extend('custom.persian_alpha_number', 'App\Infrastructure\Validator\CustomValidator@isPersianAlphabetsNumbers');
    }

    /**
     * Sharing variables in all views [Passing data to all views]
     */
    private function shareVariables()
    {
        //share data in global blade
    }

}
