<?php

namespace Esign\InlineEdit;

use Illuminate\Support\ServiceProvider;
use Esign\InlineEdit\Console\InstallCommand;
use Illuminate\Support\Facades\Route;


class InlineEditServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $config_path = function_exists('config_path') ? config_path('inline-edit.php') : 'inline-edit.php';

        $this->publishes([
            __DIR__ . '/../config/config.php' => $config_path,
        ], 'config');
        $this->publishes([
            __DIR__.'/../public/inline-edit.css' => public_path('assets/css/inline-edit.css'),
        ], 'public');
        $this->registerWebRoutes();
        $this->registerAPIRoutes();

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    protected function registerWebRoutes()
    {
        Route::group($this->webRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function registerAPIRoutes()
    {
        Route::group($this->apiRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
    }

    protected function webRouteConfiguration()
    {
        return [
            'middleware' => config('inline-edit.web-middleware'),
        ];
    }

    protected function apiRouteConfiguration()
    {
        return [
            'middleware' => config('inline-edit.api-middleware'),
        ];
    }
}
