<?php

namespace Esign\InlineEdit;

use Illuminate\Support\ServiceProvider;
use Esign\InlineEdit\Console\InstallCommand;


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
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
