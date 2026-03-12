<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [


    'name' => env('APP_NAME', 'Laravel'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    'timezone' => 'UTC',

    'locale' => 'en',

    'fallback_locale' => 'en',

    'faker_locale' => 'en_US',

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'maintenance' => [
        'driver' => 'file',
        // 'store' => 'redis',
    ],

    'providers' => ServiceProvider::defaultProviders()->merge([
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Mews\Captcha\CaptchaServiceProvider::class,
        Ssheduardo\Redsys\RedsysServiceProvider::class,
        Barryvdh\Debugbar\ServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
    ])->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        'Captcha' => Mews\Captcha\Facades\Captcha::class,
        'Redsys'  => Ssheduardo\Redsys\Facades\Redsys::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
    ])->toArray(),

];
