<?php
use App\Domain\Product\Providers\DomainServiceProvider as ProductDomainServiceProvider;

return [

    'languages' => [
        'fa' => 'Farsi',
        'en' => 'English',
    ],

    'extra_provider' => [

        /*
        * Domain Service Providers...
        */
        ProductDomainServiceProvider::class,

        /*
        * Package Service Providers...
        */

    ],

    'settings' => [
        'app_name' => env('APP_NAME'),
        'app_key' => env('APP_KEY'),
        'app_url' => env('APP_URL'),
        'app_timezone' => env('APP_TIMEZONE'),
        'app_locale' => env('APP_LOCALE'),
        'app_env' => env('APP_ENV'),
        'app_debug' => env('APP_DEBUG'),
        'app_version' => env('APP_VERSION'),
        'app_db_prefix' => env('DB_PREFIX', 'tbl_'),
    ],
];
