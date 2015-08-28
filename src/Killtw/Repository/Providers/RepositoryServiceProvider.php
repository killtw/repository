<?php

namespace Killtw\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @package Killtw\Repository\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Boot the package.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../resources/config/repository.php' => config_path('repository.php')
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../../../resources/config/repository.php', 'repository'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            \Killtw\Repository\Commands\RepositoryCommand::class,
            \Killtw\Repository\Commands\TransformerCommand::class,
            \Killtw\Repository\Commands\PresenterCommand::class,
        ]);
    }
}
