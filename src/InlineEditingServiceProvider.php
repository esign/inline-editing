<?php

namespace Esign\InlineEditing;

use Illuminate\Support\ServiceProvider;

class InlineEditingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $config_path = function_exists('config_path') ? config_path('inline-edit.php') : 'inline-edit.php';

        $this->publishes([
            __DIR__ . '/../config/config.php' => $config_path,
        ], 'config');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    public function register()
    {

    }

    protected function configPath(): string
    {
        return __DIR__ . '/../config/:package_name.php';
    }
}
