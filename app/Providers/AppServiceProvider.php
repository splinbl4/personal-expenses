<?php

namespace App\Providers;

use App\UseCase\Month\MonthAdaptiveLimit;
use App\UseCase\Month\MonthIncreaseLimit;
use App\UseCase\Month\MonthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register() :void
    {
        $this->app->singleton(MonthService::class, function (Application $app) {
            $config = $app->make('config')->get('expense');

            switch ($config['scenario']) {
                case 'increase_limit':
                    return new MonthIncreaseLimit();
                case 'adaptive_limit':
                    return new MonthAdaptiveLimit();
                default:
                    throw new \InvalidArgumentException('Undefined config');
            }
        });
    }
}
