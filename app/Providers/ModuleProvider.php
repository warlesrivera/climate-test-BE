<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $modules = [
            'User',
            'Login',
            'MapHistory',
            'City'
        ];

        foreach ($modules as $module) {
            $file ="{$module}Decorator";
            $this->app->bind("App\Modules\\{$module}\Interfaces\\I{$file}", "App\Modules\\{$module}\Decorators\\{$file}");
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
