<?php

namespace Bondacom\LaravelFileManager\Providers;

use Bondacom\LaravelFileManager\File;
use Illuminate\Support\ServiceProvider;

class LaravelFileManagerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/file-manager.php' => config_path('file-manager.php'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/file-manager.php', 'file-manager'
        );
        $config = config('file-manager');
        $this->app->bind('File', function ($app) use ($config) {
            return new File($config);
        });

    }
}